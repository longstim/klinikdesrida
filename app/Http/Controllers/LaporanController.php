<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function laporanpasienberobat()
    {
        $historypasien=DB::table('td_berobat')
                ->leftjoin('td_rekam_medis AS t1', 'td_berobat.id', '=', 't1.id_berobat')
                ->leftjoin('td_pembayaran AS t2', 't1.id', '=', 't2.id_rekam_medis')
                ->leftjoin('md_pasien AS t3', 'td_berobat.id_pasien', '=', 't3.id')
                ->select('td_berobat.*', 't1.harga AS harga', 't3.nama AS nama', 't3.alamat', 't3.no_hp')
                ->get(); 

        $newHistoryPasien = array();
        $newIndex = 0;

        foreach ($historypasien as $index => $value) 
        {

            foreach ($value as $key => $data) 
            {
                $newHistoryPasien[$newIndex][$key] = $data;
            }

            if($value->status==0)
            {
                $statusRM=DB::table('td_rekam_medis')->where('id_berobat', '=', $value->id)->first();

                if(!empty($statusRM))
                {
                    if($statusRM->status==0)
                    {
                        $statusBayar=DB::table('td_pembayaran')->where('id_rekam_medis', '=', $statusRM->id)->first();

                        $newHistoryPasien[$newIndex]['status'] = $statusBayar->status;
                    }
                    else
                    {
                        $newHistoryPasien[$newIndex]['status'] = "sudah ditangani";
                    }
                }
            }
            else
            {
                $newHistoryPasien[$newIndex]['status']="pendaftaran";
            }

            $newIndex = $newIndex + 1;
        }

        $tanggalDari ="";
        $tanggalSampai=""; 
      
        $tanggalDari = DB::table('td_berobat')->min('tanggal_berobat');
        $tanggalSampai = DB::table('td_berobat')->max('tanggal_berobat');

        if(empty($tanggalDari) || empty($tanggalSampai))
        {
            $newTanggalDari = date('d/m/Y', strtotime(now()));
            $newTanggalSampai = date('d/m/Y', strtotime(now()));
        }
        else
        {
            $newTanggalDari = customTanggalDateTime($tanggalDari, 'd/m/Y');
            $newTanggalSampai = customTanggalDateTime($tanggalSampai, 'd/m/Y');
        }
 

        return view('pages.laporan.laporanpasienberobat', ['historypasien'=>$newHistoryPasien, 'tanggalDari'=>$newTanggalDari, 'tanggalSampai'=>$newTanggalSampai]);
    }

    public function laporanpembayaran()
    {
        $historypasien=DB::table('td_berobat')
                ->where('t2.status', '=', 'lunas')
                ->leftjoin('td_rekam_medis AS t1', 'td_berobat.id', '=', 't1.id_berobat')
                ->leftjoin('td_pembayaran AS t2', 't1.id', '=', 't2.id_rekam_medis')
                ->leftjoin('md_pasien AS t3', 'td_berobat.id_pasien', '=', 't3.id')
                ->select('td_berobat.*', 't1.harga AS harga', 't3.nama AS nama', 't3.alamat', 't3.no_hp', 't2.tanggal_pembayaran')
                ->get(); 

        $newHistoryPasien = array();
        $newIndex = 0;

        foreach ($historypasien as $index => $value) 
        {

            foreach ($value as $key => $data) 
            {
                $newHistoryPasien[$newIndex][$key] = $data;
            }

            if($value->status==0)
            {
                $statusRM=DB::table('td_rekam_medis')->where('id_berobat', '=', $value->id)->first();

                if(!empty($statusRM))
                {
                    if($statusRM->status==0)
                    {
                        $statusBayar=DB::table('td_pembayaran')->where('id_rekam_medis', '=', $statusRM->id)->first();

                        $newHistoryPasien[$newIndex]['status'] = $statusBayar->status;
                    }
                    else
                    {
                        $newHistoryPasien[$newIndex]['status'] = "belum bayar";
                    }
                }
            }
            else
            {
                $newHistoryPasien[$newIndex]['status']="pendaftaran";
            }

            $newIndex = $newIndex + 1;
        }

        $tanggalDari ="";
        $tanggalSampai=""; 
      
        $tanggalDari = DB::table('td_pembayaran')->min('tanggal_pembayaran');
        $tanggalSampai = DB::table('td_pembayaran')->max('tanggal_pembayaran');

        if(empty($tanggalDari) || empty($tanggalSampai))
        {
            $newTanggalDari = date('d/m/Y', strtotime(now()));
            $newTanggalSampai = date('d/m/Y', strtotime(now()));
        }
        else
        {
            $newTanggalDari = customTanggalDateTime($tanggalDari, 'd/m/Y');
            $newTanggalSampai = customTanggalDateTime($tanggalSampai, 'd/m/Y');
        }

        return view('pages.laporan.laporanpembayaran', ['historypasien'=>$newHistoryPasien, 'tanggalDari'=>$newTanggalDari, 'tanggalSampai'=>$newTanggalSampai]);
    }

    public function cariLaporanPasienBerobat(Request $request)
    {   
        $tanggalDari = $request->input('tanggal_dari');
        $newTanggalDari = Carbon::createFromFormat('d/m/Y', $tanggalDari)->format('Y-m-d');

        $tanggalSampai = $request->input('tanggal_sampai');
        $newTanggalSampai = Carbon::createFromFormat('d/m/Y', $tanggalSampai)->format('Y-m-d');

        $historypasien=DB::table('td_berobat')
                ->whereDate('tanggal_berobat', '>=', $newTanggalDari)
                ->whereDate('tanggal_berobat', '<=', $newTanggalSampai)
                ->leftjoin('td_rekam_medis AS t1', 'td_berobat.id', '=', 't1.id_berobat')
                ->leftjoin('td_pembayaran AS t2', 't1.id', '=', 't2.id_rekam_medis')
                ->leftjoin('md_pasien AS t3', 'td_berobat.id_pasien', '=', 't3.id')
                ->select('td_berobat.*', 't1.harga AS harga', 't3.nama AS nama', 't3.alamat', 't3.no_hp')
                ->get(); 

        $newHistoryPasien = array();
        $newIndex = 0;

        foreach ($historypasien as $index => $value) 
        {

            foreach ($value as $key => $data) 
            {
                $newHistoryPasien[$newIndex][$key] = $data;
            }

            if($value->status==0)
            {
                $statusRM=DB::table('td_rekam_medis')->where('id_berobat', '=', $value->id)->first();

                if(!empty($statusRM))
                {
                    if($statusRM->status==0)
                    {
                        $statusBayar=DB::table('td_pembayaran')->where('id_rekam_medis', '=', $statusRM->id)->first();

                        $newHistoryPasien[$newIndex]['status'] = $statusBayar->status;
                    }
                    else
                    {
                        $newHistoryPasien[$newIndex]['status'] = "sudah ditangani";
                    }
                }
            }
            else
            {
                $newHistoryPasien[$newIndex]['status']="pendaftaran";
            }

            $newIndex = $newIndex + 1;
        }

        return view('pages.laporan.laporanpasienberobat', ['historypasien'=>$newHistoryPasien, 'tanggalDari'=>$tanggalDari, 'tanggalSampai'=>$tanggalSampai]);
    }

    public function cariLaporanPembayaran(Request $request)
    {   
        $tanggalDari = $request->input('tanggal_dari');
        $newTanggalDari = Carbon::createFromFormat('d/m/Y', $tanggalDari)->format('Y-m-d');

        $tanggalSampai = $request->input('tanggal_sampai');
        $newTanggalSampai = Carbon::createFromFormat('d/m/Y', $tanggalSampai)->format('Y-m-d');

        $historypasien=DB::table('td_berobat')
                ->where('t2.status', '=', 'lunas')
                ->whereDate('t2.tanggal_pembayaran', '>=', $newTanggalDari)
                ->whereDate('t2.tanggal_pembayaran', '<=', $newTanggalSampai)
                ->leftjoin('td_rekam_medis AS t1', 'td_berobat.id', '=', 't1.id_berobat')
                ->leftjoin('td_pembayaran AS t2', 't1.id', '=', 't2.id_rekam_medis')
                ->leftjoin('md_pasien AS t3', 'td_berobat.id_pasien', '=', 't3.id')
                ->select('td_berobat.*', 't1.harga AS harga', 't3.nama AS nama', 't3.alamat', 't3.no_hp', 't2.tanggal_pembayaran')
                ->get(); 

        $newHistoryPasien = array();
        $newIndex = 0;

        foreach ($historypasien as $index => $value) 
        {

            foreach ($value as $key => $data) 
            {
                $newHistoryPasien[$newIndex][$key] = $data;
            }

            if($value->status==0)
            {
                $statusRM=DB::table('td_rekam_medis')->where('id_berobat', '=', $value->id)->first();

                if(!empty($statusRM))
                {
                    if($statusRM->status==0)
                    {
                        $statusBayar=DB::table('td_pembayaran')->where('id_rekam_medis', '=', $statusRM->id)->first();

                        $newHistoryPasien[$newIndex]['status'] = $statusBayar->status;
                    }
                    else
                    {
                        $newHistoryPasien[$newIndex]['status'] = "sudah ditangani";
                    }
                }
            }
            else
            {
                $newHistoryPasien[$newIndex]['status']="pendaftaran";
            }

            $newIndex = $newIndex + 1;
        }

        return view('pages.laporan.laporanpembayaran', ['historypasien'=>$newHistoryPasien, 'tanggalDari'=>$tanggalDari, 'tanggalSampai'=>$tanggalSampai]);
    }
}

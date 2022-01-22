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

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarpembayaran()
    {
        $rekam_medis=DB::table('td_rekam_medis')->where('td_rekam_medis.status', '=', 1)
                ->leftjoin('td_berobat AS t1', 'td_rekam_medis.id_berobat', '=', 't1.id')
                ->leftjoin('md_pasien AS t2', 't1.id_pasien', '=', 't2.id')
                ->select('td_rekam_medis.*', 't2.id AS id_pasien', 't2.NRM AS NRM', 't2.nama AS nama', 't2.alamat', 't2.no_hp')
                ->get(); 

        return view('pages.pembayaran.daftarpembayaran', compact('rekam_medis'));
    }

    public function proseslunaspembayaran($id_rekam_medis)
    {
        $data = array(
          'id_rekam_medis' => $id_rekam_medis,
          'tanggal_pembayaran' => Carbon::now()->toDateTimeString(),
          'status' => 'lunas',
        );

        $data_rekam_medis = array(
          'status' => 0,
        );

        $insertID = DB::table('td_pembayaran')->insertGetId($data);

        DB::table('td_rekam_medis')->where('id','=',$id_rekam_medis)->update($data_rekam_medis);

        return Redirect::to('pembayaran')->with('message','Berhasil menyimpan data');
    }

    public function prosesbatalpembayaran($id_rekam_medis)
    {
        $data = array(
          'id_rekam_medis' => $id_rekam_medis,
          'tanggal_pembayaran' => Carbon::now()->toDateTimeString(),
          'status' => 'batal',
        );

        $data_rekam_medis = array(
          'status' => 0,
        );

        $insertID = DB::table('td_pembayaran')->insertGetId($data);

        DB::table('td_rekam_medis')->where('id','=',$id_rekam_medis)->update($data_rekam_medis);

        return Redirect::to('pembayaran')->with('message','Berhasil menyimpan data');
    }

    public function cetakkuitansi($id_rekam_medis)
    {
        $rekam_medis=DB::table('td_rekam_medis')->where('td_rekam_medis.id', '=', $id_rekam_medis)
                ->leftjoin('td_berobat AS t1', 'td_rekam_medis.id_berobat', '=', 't1.id')
                ->leftjoin('md_pasien AS t2', 't1.id_pasien', '=', 't2.id')
                ->select('td_rekam_medis.*', 't2.NRM AS NRM','t2.nama AS nama', 't2.alamat', 't2.no_hp')
                ->first(); 

        return view('pages.pembayaran.cetakkuitansi', compact('rekam_medis'));
    }

    public function cetaksuratsakit(Request $request)
    {
        $rekam_medis=DB::table('td_rekam_medis')
                ->where('td_rekam_medis.id', '=', $request->input('id_header'))
                ->leftjoin('td_berobat AS t1', 'td_rekam_medis.id_berobat', '=', 't1.id')
                ->leftjoin('md_pasien AS t2', 't1.id_pasien', '=', 't2.id')
                ->select('td_rekam_medis.*', 't2.NRM AS NRM', 't2.nama AS nama', 't2.alamat', 't2.no_hp', 't2.tanggal_lahir AS tanggal_lahir')
                ->first(); 

        
        $newTanggalAwal = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_awal'))->format('d-m-Y');
        $newTanggalAkhir = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_akhir'))->format('d-m-Y');

        $dateAwal = strtotime($newTanggalAwal);
        $dateAkhir = strtotime($newTanggalAkhir);

        $datediff = $dateAkhir - $dateAwal;

        $days = round($datediff / 86400) + 1;

        $newTanggalLahir = Carbon::createFromFormat('Y-m-d', $rekam_medis->tanggal_lahir)->format('d-m-Y');

        $datasakit = array(
            'tanggal_awal' => $newTanggalAwal,
            'tanggal_akhir' => $newTanggalAkhir,
            'jlh_hari' => $days,
            'umur' => getAge($newTanggalLahir),
        );
        

        return view('pages.pembayaran.cetaksuratsakit', compact('rekam_medis', 'datasakit'));
    }

    public function cetaksuratsehat(Request $request)
    {
        $rekam_medis=DB::table('td_rekam_medis')
                ->where('td_rekam_medis.id', '=', $request->input('id_header'))
                ->leftjoin('td_berobat AS t1', 'td_rekam_medis.id_berobat', '=', 't1.id')
                ->leftjoin('md_pasien AS t2', 't1.id_pasien', '=', 't2.id')
                ->select('td_rekam_medis.*', 't2.NRM AS NRM', 't2.nama AS nama', 't2.alamat', 't2.no_hp', 't2.tanggal_lahir AS tanggal_lahir')
                ->first(); 

        $newTanggalLahir = Carbon::createFromFormat('Y-m-d', $rekam_medis->tanggal_lahir)->format('d-m-Y');

        $datasehat = array(
            'tanggal_lahir' => $newTanggalLahir,
            'keperluan' => $request->input('keperluan'),
        );
        

        return view('pages.pembayaran.cetaksuratsehat', compact('rekam_medis', 'datasehat'));
    }
}

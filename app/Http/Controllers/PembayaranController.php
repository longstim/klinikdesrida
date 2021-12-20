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
                ->select('td_rekam_medis.*', 't2.nama AS nama', 't2.alamat', 't2.no_hp')
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
                ->select('td_rekam_medis.*', 't2.nama AS nama', 't2.alamat', 't2.no_hp')
                ->first(); 

        return view('pages.pembayaran.cetakkuitansi', compact('rekam_medis'));
    }
}

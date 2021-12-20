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

class PemeriksaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarpasienberobat()
    {
        $pasienberobat=DB::table('td_berobat')->where('status', '=', 1)
                ->leftjoin('md_pasien AS t1', 'td_berobat.id_pasien', '=', 't1.id')
                ->select('td_berobat.*', 't1.nama AS nama', 't1.alamat', 't1.no_hp')
                ->get(); 

        return view('pages.pemeriksaan.daftarpasienberobat', compact('pasienberobat'));
    }

    public function pemeriksaanpasien($id_berobat)
    {
        $pasienberobat=DB::table('td_berobat')
                ->where('id', '=', $id_berobat)
                ->first(); 

        $pasien = DB::table('md_pasien')->where('id', '=', $pasienberobat->id_pasien)->first(); 

        $rekam_medis=DB::table('td_rekam_medis')->get(); 

        return view('pages.pemeriksaan.form_pemeriksaanpasien', compact('pasienberobat', 'pasien', 'rekam_medis'));
    }

    public function prosespemeriksaanpasien(Request $request)
    {
        $validatedData = $request->validate([
          'keluhan' => 'required',
          'diagnosa' => 'required',
          'alergi' => 'required',
          'catatan' => 'required',
          'tensi' => 'required',
          'tinggi' => 'required',
          'berat' => 'required',
          'temperatur' => 'required',
          'obat' => 'required',
          'harga' => 'required',
        ]);

        $data = array(
          'id_berobat' => $request->input('id'),
          'tanggal_ditangani' => Carbon::now()->toDateTimeString(),
          'keluhan' => $request->input('keluhan'),
          'diagnosa' => $request->input('diagnosa'),
          'alergi' => $request->input('alergi'),
          'catatan' => $request->input('catatan'),
          'tensi' => $request->input('tensi'),
          'tinggi' => $request->input('tinggi'),
          'berat' => $request->input('berat'),
          'temperatur' => $request->input('temperatur'),
          'obat' => $request->input('obat'),
          'harga' => $request->input('harga'),
          'status' => 1,
        );

        $data_berobat = array(
          'status' => 0,
        );

        $insertID = DB::table('td_rekam_medis')->insertGetId($data);

        DB::table('td_berobat')->where('id','=',$request->input('id'))->update($data_berobat);

        return Redirect::to('pembayaran')->with('message','Berhasil menyimpan data');
    }
}

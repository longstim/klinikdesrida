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

class PasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarpasien()
    {
        $pasien=DB::table('md_pasien')->get(); 

        return view('pages.pasien.daftarpasien', compact('pasien'));
    }

    public function tambahpasien()
    {
        $pasien=DB::table('md_pasien')->get();

        return view('pages.pasien.form_tambahpasien',['pasien'=>$pasien]);
    }

    public function prosestambahpasien(Request $request)
    {
        $validatedData = $request->validate([
          'nama' => 'required',
          'tanggal_lahir' => 'required',
          'no_hp' => 'required',
          'alamat' => 'required',
          'jenis_kelamin' => 'required',
        ]);

        $tanggalLahir = $request->input('tanggal_lahir');
        $newTanggalLahir = Carbon::createFromFormat('d/m/Y', $tanggalLahir)->format('Y-m-d');

        $data = array(
          'nama' => $request->input('nama'),
          'tanggal_lahir' => $newTanggalLahir,
          'no_hp' => $request->input('no_hp'),
          'alamat' => $request->input('alamat'),
          'jenis_kelamin' => $request->input('jenis_kelamin'),
          'riwayat_alergi' => $request->input('riwayat_alergi'),
        );

        $insertID = DB::table('md_pasien')->insertGetId($data);

        return Redirect::to('pasien')->with('message','Berhasil menyimpan data');
    }

    public function ubahpasien($id_pasien)
    {
        $pasien=DB::table('md_pasien')->where('id','=',$id_pasien)->first();

        return view('pages.pasien.form_ubahpasien', ['pasien'=>$pasien]);
    }

    public function prosesubahpasien(Request $request)
    {       
        $tanggalLahir = $request->input('tanggal_lahir');
        $newTanggalLahir = Carbon::createFromFormat('d/m/Y', $tanggalLahir)->format('Y-m-d');

        $data = array(
          'nama' => $request->input('nama'),
          'tanggal_lahir' => $newTanggalLahir,
          'no_hp' => $request->input('no_hp'),
          'alamat' => $request->input('alamat'),
          'jenis_kelamin' => $request->input('jenis_kelamin'),
          'riwayat_alergi' => $request->input('riwayat_alergi'),
        );

        DB::table('md_pasien')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('pasien')->with('message','Berhasil menyimpan data');
    }

    public function hapusruangan($id_pasien)
    {
        $pasien = DB::table('md_pasien')->where('id','=',$id_pasien)->delete();

        return Redirect::to('pasien')->with('message','Berhasil menghapus data');
    }

    public function pasienberobat($id_pasien)
    {
        $pasien = DB::table('md_pasien')->where('id','=',$id_pasien)->first();

         $data = array(
          'id_pasien' => $id_pasien,
          'tanggal_berobat' => Carbon::now()->toDateTimeString(),
          'status' => 1,
        );

        $insertID = DB::table('td_berobat')->insertGetId($data);

        return Redirect::to('pasienberobat')->with('message','Berhasil menyimpan data');
    }

    public function detailpasien($id_pasien)
    {
        $pasien=DB::table('md_pasien')->where('id', '=', $id_pasien)->first();

        $pasienberobat=DB::table('td_berobat')
                ->where('td_berobat.id_pasien', '=', $id_pasien)
                ->where('td_berobat.status', '=', 0)
                ->leftjoin('td_rekam_medis AS t1', 'td_berobat.id', '=', 't1.id_berobat')
                ->leftjoin('md_pasien AS t2', 'td_berobat.id_pasien', '=', 't2.id')
                ->select('td_berobat.*', 't1.*', 't2.nama AS nama', 't2.alamat', 't2.no_hp')
                ->orderBy('t1.tanggal_ditangani','desc')
                ->get(); 

        return view('pages.pasien.detailpasien',['pasien'=>$pasien, 'pasienberobat'=>$pasienberobat]);
    }
}

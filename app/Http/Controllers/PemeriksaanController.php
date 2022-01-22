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
                ->select('td_berobat.*', 't1.NRM AS NRM', 't1.nama AS nama', 't1.alamat', 't1.no_hp')
                ->get(); 

        return view('pages.pemeriksaan.daftarpasienberobat', compact('pasienberobat'));
    }

    public function pemeriksaanpasien($id_berobat)
    {
        $pasienberobat=DB::table('td_berobat')
                ->where('id', '=', $id_berobat)
                ->first(); 

        $pasien = DB::table('md_pasien')->where('id', '=', $pasienberobat->id_pasien)->first(); 

        $datarm=DB::select('SELECT t1.tensi, t1.berat, t1.tinggi, t1.temperatur, t1.alergi, t1.tanggal_ditangani FROM td_rekam_medis t1 INNER JOIN (SELECT MAX(tanggal_ditangani) AS waktu, td_berobat.id_pasien FROM td_rekam_medis 
            left join td_berobat ON td_rekam_medis.id_berobat = td_berobat.id 
            where td_berobat.id_pasien = '.$pasienberobat->id_pasien. ' group by td_berobat.id_pasien) t2 ON t1.tanggal_ditangani = t2.waktu');
        
        $i=0;

        if(!empty($datarm))
        {
            foreach($datarm as $rm)
            {
                $rekam_medis[$i]["tensi"] = $rm->tensi;
                $rekam_medis[$i]["berat"] = $rm->berat;
                $rekam_medis[$i]["tinggi"] = $rm->tinggi;
                $rekam_medis[$i]["temperatur"] = $rm->temperatur;
                $rekam_medis[$i]["alergi"] = $rm->alergi;
                $i++;
            }
        }
        else
        {
            $rekam_medis[$i]["tensi"] = "";
            $rekam_medis[$i]["berat"] = "";
            $rekam_medis[$i]["tinggi"] = "";
            $rekam_medis[$i]["temperatur"] = "";
            $rekam_medis[$i]["alergi"] = "";
            $i++;
        }

         //dd($rekam_medis);

        $diagnosa = DB::table('md_diagnosa')->get();


        return view('pages.pemeriksaan.form_pemeriksaanpasien', compact('pasienberobat', 'pasien', 'rekam_medis', 'diagnosa'));
    }

    public function prosespemeriksaanpasien(Request $request)
    {
        $validatedData = $request->validate([
          'keluhan' => 'required',
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

        //dd($request->input('diagnosa'));

        $insertID = DB::table('td_rekam_medis')->insertGetId($data);

        foreach($request->input('diagnosa') as $dd)
        {
            $datadiagnosa = array(
                'id_rekam_medis' => $insertID,
                'id_diagnosa' => $dd,
            );

            $insertIDDiagnosa = DB::table('td_diagnosa_pasien')->insertGetId($datadiagnosa);
        }

        DB::table('td_berobat')->where('id','=',$request->input('id'))->update($data_berobat);

        return Redirect::to('pembayaran')->with('message','Berhasil menyimpan data');
    }
}

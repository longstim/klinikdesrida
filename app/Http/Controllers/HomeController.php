<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datapasien = DB::table('md_pasien')->count();
        $jlhpasienberobat = DB::table('td_berobat')->count();
        $jlhpenghasilan = DB::table('td_pembayaran')
                ->where('td_pembayaran.status', '=', 'lunas')
                ->leftjoin('td_rekam_medis AS t1', 'td_pembayaran.id_rekam_medis', '=', 't1.id')
                ->sum('t1.harga');

        $data = [
          'datapasien' => $datapasien,
          'jlhpasienberobat' => $jlhpasienberobat,
          'jlhpenghasilan' => $jlhpenghasilan,
        ];
        
        return view('home', compact('data'));
    }
}

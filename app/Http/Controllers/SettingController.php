<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

class SettingController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftaruser()
    {
        $user=DB::table('users')->get(); 

        return view('pages.user.daftaruser', compact('user'));
    }

    public function tambahuser()
    {
        $user=DB::table('users')->get();

        return view('pages.user.form_tambahuser',['user'=>$user]);
    }

    public function prosestambahuser(Request $request)
    {
        $validatedData = $request->validate([
          'username' => 'required|string|max:255|unique:users,username',
          'password' => 'required|string|confirmed',
        ]);

        $data = array(
          'name' => $request->input('nama'),
          'username' => $request->input('username'),
          'email' => $request->input('email'),
          'role' => $request->input('role'),
          'password' => Hash::make($request->input('password')),
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
        );

        $insertID = DB::table('users')->insertGetId($data);

        return Redirect::to('user')->with('message','Berhasil menyimpan data');
    }

    public function ubahuser($id_user)
    {
        $user=DB::table('users')->where('id','=',$id_user)->first();

        return view('pages.user.form_ubahuser', ['user'=>$user]);
    }

    public function prosesubahuser(Request $request)
    {       

        $validatedData = $request->validate([
          'password' => 'required|string|confirmed',
        ]);

        $data = array(
          'name' => $request->input('nama'),
          'username' => $request->input('username'),
          'email' => $request->input('email'),
          'role' => $request->input('role'),
          'password' => Hash::make($request->input('password')),
          'updated_at' => date("Y-m-d H:i:s"),
        );

        DB::table('users')->where('id','=',$request->input('id'))->update($data);
  
        return Redirect::to('user')->with('message','Berhasil menyimpan data');
    }

    public function hapususer($id_user)
    {
        $user = DB::table('users')->where('id','=',$id_user)->delete();

        return Redirect::to('user')->with('message','Berhasil menghapus data');
    }
}

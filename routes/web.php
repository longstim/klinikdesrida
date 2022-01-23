<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/adminlte', function () {
    return view('admin/adminlte');
});


//Pasien
Route::get('pasien', 'PasienController@daftarpasien');

Route::get('tambahpasien', 'PasienController@tambahpasien');

Route::post('prosestambahpasien', 'PasienController@prosestambahpasien');

Route::get('ubahpasien/{id_pasien}','PasienController@ubahpasien');

Route::post('prosesubahpasien','PasienController@prosesubahpasien');

Route::get('hapuspasien/{id_pasien}','PasienController@hapuspasien');

Route::get('pasienberobat/{id_pasien}','PasienController@pasienberobat');

Route::get('detailpasien/{id_pasien}','PasienController@detailpasien');


//Pemeriksaan
Route::get('pasienberobat', 'PemeriksaanController@daftarpasienberobat');

Route::get('pemeriksaanpasien/{id_berobat}', 'PemeriksaanController@pemeriksaanpasien');

Route::post('prosespemeriksaanpasien', 'PemeriksaanController@prosespemeriksaanpasien');


//Pembayaran
Route::get('pembayaran', 'PembayaranController@daftarpembayaran');

Route::get('proseslunaspembayaran/{id_rekam_medis}', 'PembayaranController@proseslunaspembayaran');

Route::get('prosesbatalpembayaran/{id_rekam_medis}', 'PembayaranController@prosesbatalpembayaran');

Route::get('cetakkuitansi/{id_rekam_medis}', 'PembayaranController@cetakkuitansi');

Route::post('cetaksuratsakit', 'PembayaranController@cetaksuratsakit');

Route::post('cetaksuratsehat', 'PembayaranController@cetaksuratsehat');


//Laporan
Route::get('laporanpasienberobat', 'LaporanController@laporanpasienberobat');

Route::get('laporanpembayaran', 'LaporanController@laporanpembayaran');

Route::post('cariLaporanPasienBerobat', 'LaporanController@cariLaporanPasienBerobat');

Route::post('cariLaporanPembayaran', 'LaporanController@cariLaporanPembayaran');


//Setting

Route::get('user', 'SettingController@daftaruser');

Route::get('tambahuser', 'SettingController@tambahuser');

Route::post('prosestambahuser', 'SettingController@prosestambahuser');

Route::get('ubahuser/{id_user}','SettingController@ubahuser');

Route::post('prosesubahuser','SettingController@prosesubahuser');

Route::get('hapususer/{id_user}','SettingController@hapususer');

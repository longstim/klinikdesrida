<?php
   
	function customTanggal($date, $date_format)
	{
	    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);   
	}

    function customTanggalDateTime($date, $date_format)
    {
         return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format($date_format);
    }
	    
    function formatRupiah($angka)
    { 
    	$hasil = "Rp ".number_format($angka,0, ',' , '.'); 

    	return $hasil; 
	}

    function getNotifikasi()
    {
        $newIndex=10;

        return $newIndex;
    }

    function jumlahPasien($tanggalDari, $tanggalSampai)
    {
        $newTanggalDari = \Carbon\Carbon::createFromFormat('d/m/Y', $tanggalDari)->format('Y-m-d');

        $newTanggalSampai = \Carbon\Carbon::createFromFormat('d/m/Y', $tanggalSampai)->format('Y-m-d');

        $total= DB::table('td_berobat')
            ->whereDate('tanggal_berobat', '>=', $newTanggalDari)
            ->whereDate('tanggal_berobat', '<=', $newTanggalSampai)
            ->count();

        return $total;
    }

    function jumlahPendapatan($tanggalDari, $tanggalSampai)
    {
        $newTanggalDari = \Carbon\Carbon::createFromFormat('d/m/Y', $tanggalDari)->format('Y-m-d');

        $newTanggalSampai = \Carbon\Carbon::createFromFormat('d/m/Y', $tanggalSampai)->format('Y-m-d');

        $penghasilan=DB::table('td_pembayaran')
            ->where('td_pembayaran.status', '=', 'lunas')
            ->whereDate('tanggal_pembayaran', '>=', $newTanggalDari)
            ->whereDate('tanggal_pembayaran', '<=', $newTanggalSampai)
            ->leftjoin('td_rekam_medis AS t1', 'td_pembayaran.id_rekam_medis', '=', 't1.id')
            ->sum('t1.harga');

        return $penghasilan;
    }
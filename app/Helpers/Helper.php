<?php
   
	function customTanggal($date, $date_format)
	{
	    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);   
	}

    function customTanggalDateTime($date, $date_format)
    {
         return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format($date_format);
    }

    function getAge($birthdate)
    {
        $currentDate = date("d-m-Y");

        $age = date_diff(date_create($birthdate), date_create($currentDate));

        return $age->format("%y");
    }
	    
    function formatRupiah($angka)
    { 
    	$hasil = "Rp ".number_format($angka,0, ',' , '.'); 

    	return $hasil; 
	}

    function formatNumber($angka)
    { 
        $hasil = number_format($angka,0, ',' , '.'); 

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

    function diagnosaPasien($id_rekammedis)
    {
        $diagnosa=DB::table('td_diagnosa_pasien')
                ->where('td_diagnosa_pasien.id_rekam_medis', '=', $id_rekammedis)
                ->leftjoin('md_diagnosa AS t1', 'td_diagnosa_pasien.id_diagnosa', '=', 't1.id')
                ->select('td_diagnosa_pasien.*', 't1.indonesian_name AS nama_diagnosa')
                ->get(); 

        $stringDiagnosa="";
        $i = 0;
        $len = count($diagnosa);

        foreach($diagnosa as $val)
        {
            if ($i == $len - 1) 
            {
                $stringDiagnosa = $stringDiagnosa.$val->nama_diagnosa ;
            }
            else
            {
                $stringDiagnosa = $stringDiagnosa.$val->nama_diagnosa."; ";
            }

            $i++;
        }

        return $stringDiagnosa;
    }

    function getNamaHariIni()
    {

        $hari = date ("D");

        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;

            case 'Mon':         
                $hari_ini = "Senin";
            break;

            case 'Tue':
                $hari_ini = "Selasa";
            break;

            case 'Wed':
                $hari_ini = "Rabu";
            break;

            case 'Thu':
                $hari_ini = "Kamis";
            break;

            case 'Fri':
                $hari_ini = "Jumat";
            break;

            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";     
            break;
        }

        return $hari_ini;
    }

    function getBulanRomawi($tgl){

        $bln = date("m",strtotime($tgl));

        switch ($bln){
            case 1: 
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
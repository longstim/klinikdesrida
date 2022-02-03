<html>
<head>
<title>Surat Keterangan Sakit</title>
  <style type="text/css">
      td {font-family:"arial"; font-size:12pt}
      th {font-family:"arial"; font-weight:bold; font-size:12pt}
      a {text-decoration:none;}
      a:hover {color:red}
      textarea {font-family:"arial"; font-size:9pt}
      input {font-family:"arial"; font-size:9pt}
  </style>
  <link REL="shortcut icon" HREF="/favicon.ico" TYPE="image/x-icon">
</head>

<body bgcolor="white" onload="window.print()">
<font face="arial">
<center>
   <table border="0" width="650" cellpadding="1" cellspacing="0" id="kopsurat">
      <tr>
        <td align="center" style="font-size:20pt"><b>Praktek dr. Yoseph Christian & dr. Desrida</td>
      </tr>
       <tr valign="top">
          <td align="center" style="font-size:12pt">Jl. Raya Deli Tua KM 8,5</td>
      </tr>
       <tr>
          <td align="center" style="font-size:12pt">Komplek Sanur Walk Blok B No.1 Deli Tua</td>
      </tr>
  </table>
  <hr style="border:2px solid black;color:black;background-color:black;" width="750">
  <hr style="border:1px solid black;color:black;background-color:black; margin-top:-6px;" width="750" >
  <table border=0 width="650">
    <tr>
      <br>
      <td align="center"><b style="font-size:16pt"><u>SURAT KETERANGAN SAKIT</u></b><br>
        No :{{$datasakit["no_surat"]}}<br>
      </td>
    </tr>

    <tr>
      <td>
         <br>
        <p>
            Yang bertanda tangan di bawah ini menerangkan bahwa :
        </p>
        <table border=0 >
          <tr>
            <td>Nama</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$rekam_medis->nama}}</td>
          </tr>
          <tr>
            <td>Umur</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$datasakit["umur"]}} Tahun</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$rekam_medis->alamat}}</td>
          </tr>
        </table>
        <p>
            Perlu beristirahat karena sakit, selama {{$datasakit["jlh_hari"]}} hari terhitung tanggal {{$datasakit["tanggal_awal"]}} s/d {{$datasakit["tanggal_akhir"]}}.
        </p>
        <p>
            Harap yang berkepentingan maklum.
        </p>
      </td>
    </tr>
    <tr>
      <td>
      <br>

        <table border=0 width="100%">
          <tr>
            <br><br>
           
            <td width="50%"></td>
            <td align="center">
              Deli Tua, {{customTanggalDateTime($rekam_medis->tanggal_ditangani, 'd M Y')}}<br>
              <br><br><br><br>
              <b>{{$penandatangan}}</b>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</center>
</font>

</body>
</html>

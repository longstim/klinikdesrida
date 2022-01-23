<html>
<head>
<title>Kuitansi</title>
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
        <td align="center" style="font-size:25pt"><b>Klinik dr. Yoseph Christian</td>
      </tr>
      <tr>
        <td align="center" style="font-size:14pt"><b>SIP : 5796/440/SIPD/XI/DS/2015</td>
      </tr>
      <tr valign="top">
          <td align="center" style="font-size:12pt">Jl. Raya Deli Tua KM 8,5</td>
      </tr>
      <tr>
          <td align="center" style="font-size:12pt">Komplek Sanur Walk Blok B No.1 Deli Tua</td>
      </tr>
      <tr valign="top">
          <td align="center" style="font-size:12pt">Telp: 061 - 42071507</td>
      </tr>
  </table>
  <hr style="border:2px solid black;color:black;background-color:black;" width="750">
  <hr style="border:1px solid black;color:black;background-color:black; margin-top:-6px;" width="750" >
  <table border=0 width="650">
    <tr>
      <br>
      <td align="center"><b style="font-size:16pt"><u>BUKTI PEMBAYARAN</u></b><br>
        No : {{sprintf('%04s', $rekam_medis->id)}}/KUI/{{getBulanRomawi(customTanggalDateTime($rekam_medis->tanggal_ditangani, 'd M Y'))}}/{{date("Y",strtotime(customTanggalDateTime($rekam_medis->tanggal_ditangani, 'd M Y')))}}<br>
      </td>
    </tr>

    <tr>
      <td>
         <br><br>
        <table border=0 >
          <tr>
            <td>NRM</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$rekam_medis->NRM}}</td>
          </tr>
          <tr>
            <td>Nama</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$rekam_medis->nama}}</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$rekam_medis->alamat}}</td>
          </tr>
          <tr>
            <td>No. HP</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$rekam_medis->no_hp}}</td>
          </tr>
          <tr>
            <td>Diagnosa</td>
            <td width="40px"></td>
            <td>:</td>
            <td style="text-align:justify;">{{diagnosaPasien($rekam_medis->id)}}</td>
          </tr>
          <tr>
            <td>Untuk Pembayaran</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{$rekam_medis->obat}}</td>
          </tr>
          <tr>
            <td>Jumlah Harga</td>
            <td width="40px"></td>
            <td>:</td>
            <td>{{formatRupiah($rekam_medis->harga)}}</td>
          </tr>
           <tr border="1">
          </tr>
        </table>
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
              <b>dr. Yoseph Christian</b>
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

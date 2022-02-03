@extends('layouts.dashboard')
@section('content')
  <!-- Main content -->

    <div class="row">
      <div class="col-md-12">
        <center>
       <table border="0" cellpadding="1" cellspacing="0" id="kopsurat">
          <tr>
            <td align="center" style="font-size:25pt"><b>Praktek dr. Yoseph Christian & dr. Desrida</b></td>
          </tr>
          <tr valign="top">
              <td align="center" style="font-size:12pt">Jl. Raya Deli Tua KM 8,5 Komplek Sanur Walk Blok B No.1 Deli Tua</td>
          </tr>
      </table>
      </center>
     </div>
    </div>

    <hr/>
    @php
      if(Auth::user()->role == "admin" || Auth::user()->role == "dokter")
      {
    @endphp
   <div class="row">
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$data['datapasien']}}</h3>

            <p>Data Pasien</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{url('pasien')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$data['jlhpasienberobat']}}</h3>

            <p>Jumlah Pasien Berobat</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{url('laporanpasienberobat')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{formatRupiah($data['jlhpenghasilan'])}}</h3>

            <p>Total Pendapatan</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{url('laporanpembayaran')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
        <!-- ./col -->
  </div>
  @php
  }
  @endphp
       

<!-- ChartJS -->
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
@endsection

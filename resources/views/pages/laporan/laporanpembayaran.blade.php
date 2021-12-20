@extends('layouts.dashboard')
@section('page_heading','Laporan Pembayaran')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Laporan Pembayaran</li>
</ol>
@endsection
@section('content')
<style>
  #dropdown-action-id
  {
    min-width: 5rem;
  }

  #dropdown-action-id .dropdown-item:hover
  {
    color:#007bff;
  }

  #dropdown-action-id .dropdown-item:active
  {
    color:#fff;
  }
</style>
  <div class="row">

    <div class="col-12">
     <form role="form" id="searchTanggalPembayaran" method="post" action="{{url('cariLaporanPembayaran')}}" >
        {{ csrf_field() }}
      <div class="form-group row">
        <div class="col-sm-12 row">
          <label class="col-sm-2 col-form-label">Dari Tanggal</label>
          <div class="col-sm-3">
              <div class="input-group date">
                <input type="text" name="tanggal_dari" class="form-control" id="datepicker" placeholder="dd/mm/yyyy" value="{{($tanggalDari!='') ? $tanggalDari : date('d/m/Y', strtotime(now()))}}">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
              </div>
          </div>
          <label class="col-sm-2 col-form-label float-right">Sampai Tanggal</label>
          <div class="col-sm-3">
              <div class="input-group date">
                <input type="text" name="tanggal_sampai" class="form-control" id="datepicker2" placeholder="dd/mm/yyyy" value="{{($tanggalSampai!='') ? $tanggalSampai : date('d/m/Y', strtotime(now()))}}"">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
              </div>
          </div>
          <div class="col-sm-2">
            <button type="submit" class="btn btn-success">Cari</button>
          </div>
        </div>
      </div>
      </form>
    </div>

    <div class="col-sm-12">
        <p><i>Jumlah pendapatan dari tanggal {{$tanggalDari}} sampai dengan {{$tanggalSampai}} adalah sebanyak : <b>{{formatRupiah(jumlahPendapatan($tanggalDari, $tanggalSampai))}}</b></i></p>
    </div>

    <div class="col-12">
      <div>
        @if(Session::has('message'))
            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
        @endif
      </div>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-hover table-striped">
            <thead>
            <tr style="background-color:#018975; color:#fff">
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No. HP</th>
              <th>Tanggal Pembayaran</th>
              <th style="width: 15%;">Tagihan</th>
              <th>Tindakan</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($historypasien as $data)  
               <tr>
                  <td>{{++$no}}</td>
                  <td>{{$data['nama']}}</td>
                  <td>{{$data['alamat']}}</td>
                  <td>{{$data['no_hp']}}</td>
                  <td>{{customTanggalDateTime($data['tanggal_pembayaran'], 'd-m-Y')}}</td>
                  <td>{{formatRUpiah($data['harga'])}}</td>
                  <td style="text-align:center;">
                    <a class="btn btn-primary btn-sm" href="detailpasien/{{$data['id']}}">Detail</a>&nbsp;
                  </td>
               </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>

  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script>
    $( document ).ready(function () {

      //DataTable
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });

      //SweetAlert Success
      var message = $("#idmessage").val();
      var message_text = $("#idmessage_text").val();

      if(message=="1")
      {
        Swal.fire({     
           icon: 'success',
           title: 'Success!',
           text: message_text,
           showConfirmButton: false,
           timer: 1500
        })
      }

      //SweetAlert Lunas
     $(document).on("click", ".swalLunas",function(event) {  
        event.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
          title: 'Apakah anda yakin melunasi pembayaran ini?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          confirmButtonText: 'Ya, Setuju',
          cancelButtonText: 'Tidak'
        }).then((result) => {
        if (result.value) 
        {
            window.location.href = url;
        }
      });
    });

      //SweetAlert Delete
     $(document).on("click", ".swalDelete",function(event) {  
        event.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
          title: 'Apakah anda yakin membatalkan pembayaran ini?',
          text: 'Anda tidak akan dapat mengembalikan pembayaran ini!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          confirmButtonText: 'Ya, Batalkan',
          cancelButtonText: 'Tidak'
        }).then((result) => {
        if (result.value) 
        {
            window.location.href = url;
        }
      });
    });

    //Date picker2
    $('#datepicker2').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    })

  });
  </script>
@endsection
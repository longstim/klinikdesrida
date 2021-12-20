@extends('layouts.dashboard')
@section('page_heading','Daftar Pembayaran')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Daftar Pembayaran</li>
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
              <th>Harga</th>
              <th>Status</th>
              <th style="width:30%">Tindakan</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($rekam_medis as $data)  
               <tr>
                  <td>{{++$no}}</td>
                  <td>{{$data->nama}}</td>
                  <td>{{$data->alamat}}</td>
                  <td>{{$data->no_hp}}</td>
                  <td>{{formatRUpiah($data->harga)}}</td>
                  <td><span class="badge badge-secondary">Belum Bayar</span></td>
                  <td style="text-align:center;">
                    <a class="btn btn-warning btn-sm" href="detailpasien/{{$data->id}}">Edit</a>&nbsp;
                    <a class="btn btn-danger btn-sm swalDelete" href="prosesbatalpembayaran/{{$data->id}}">Batal</a>&nbsp;
                    <a class="btn btn-primary btn-sm swalLunas" href="proseslunaspembayaran/{{$data->id}}">Lunas</a>
                    <a class="btn btn-info btn-sm" href="cetakkuitansi/{{$data->id}}">Kuitansi</a>&nbsp;
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


  });
  </script>
@endsection
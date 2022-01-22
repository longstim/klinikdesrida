@extends('layouts.dashboard')
@section('page_heading','Detail Pasien')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Detail Pasien</li>
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
      <p></p>
      <div>
        @if(Session::has('message'))
            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
        @endif
      </div>

     <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:30%">NRM</th>
            <td>{{$pasien->NRM}}</td>
          </tr>
          <tr>
            <th style="width:30%">Nama</th>
            <td>{{$pasien->nama}}</td>
          </tr>
          <tr>
            <th style="width:30%">Alamat</th>
            <td>{{$pasien->alamat}}</td>
          </tr>
          <tr>
            <th style="width:30%">No. HP</th>
            <td>{{$pasien->no_hp}}</td>
          </tr>
        </table>
    </div>
    <hr/>

    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr style="background-color:#28a745; color:#fff">
          <th>Riwayat Pengobatan</th>
        </tr>
        </thead>
        <tbody>
          @foreach($pasienberobat as $data) 
            <tr>
              <td>
                Tanggal Kedatangan : <b>{{customTanggalDateTime($data->tanggal_berobat, 'm/d/Y')}}</b><br/>
                Tinggi Badan : <b>{{$data->tinggi}} cm</b> <br/>
                Berat Badan : <b>{{$data->berat}} Kg</b> <br/>
                Temperatur : <b>{{$data->temperatur}} °C</b> <br/>
                Tensi : <b>{{$data->tensi}} mmHg</b> <br/>
                Keluhan : <b>{{$data->keluhan}}</b> <br/>
                Diagnosa : <b>{{diagnosaPasien($data->id_rekammedis)}}</b> <br/>
                Alergi : <b>{{$data->alergi}} </b> <br/>
                Catatan : <b>{{$data->catatan}} </b> <br/>
                Obat : <b>{{$data->obat}}</b> <br/>
                Harga : <b>{{formatRupiah($data->harga)}}</b> <br/>
              </td>
            </tr>
          @endforeach
      </tbody>
    </table>

    </div>
    <!-- /.col -->
  </div>
</body>

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

      //SweetAlert Delete
     $(document).on("click", ".swalDelete",function(event) {  
        event.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
          title: 'Apakah anda yakin menghapus data ini?',
          text: 'Anda tidak akan dapat mengembalikan data ini!',
          icon: 'error',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
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
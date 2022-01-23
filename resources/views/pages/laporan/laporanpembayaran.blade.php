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
              <th>NRM</th>
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
                  <td>{{$data['NRM']}}</th>
                  <td>{{$data['nama']}}</td>
                  <td>{{$data['alamat']}}</td>
                  <td>{{$data['no_hp']}}</td>
                  <td>{{customTanggalDateTime($data['tanggal_pembayaran'], 'd-m-Y')}}</td>
                  <td>{{formatRupiah($data['harga'])}}</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Cetak
                      <span class="caret"></span>
                      </button>
                      <div class="dropdown-menu" id="dropdown-action-id">
                        <a class="dropdown-item" href="{{url('cetaksuratsakit')}}" type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modal-detail-sakit" onclick ="changeIDRMSakit({{$data['id_rekammedis']}})">Surat Sakit</a>
                        <a class="dropdown-item" href="{{url('cetaksuratsehat')}}" type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modal-detail-sehat" onclick ="changeIDRMSehat({{$data['id_rekammedis']}})">Surat Sehat</a>
                        <a class="dropdown-item" href="{{url('cetakkuitansi/'.$data['id_rekammedis'])}}" type="button" class="btn btn-success float-right">Kuitansi</a>
                      </div>
                    </div>
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


  <!-- Modal Surat Sakit-->
<div class="modal fade" id="modal-detail-sakit">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="row">
      <!-- left column -->
      <div class="col-md-12">
      <!-- jquery validation -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Cetak Surat Keterangan Sakit</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" id="cetaksuratsakit" method="post" action="{{url('cetaksuratsakit')}}" >
            {{ csrf_field() }}
          <input type="hidden" name="id_header_sakit" class="form-control" id="txtIDHeaderSakit"></input>
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label>Tanggal Sakit</label>
                      <div class="row">
                         <div class="col-md-4">
                          <div class="input-group date">
                                <input type="text" name="tanggal_awal" class="form-control" id="datepickerawal" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                          <h5 style="margin-left: 10px">s/d</h5>
                          </div>
                          <div class="col-md-4">
                            <div class="input-group date">
                              <input type="text" name="tanggal_akhir" class="form-control" id="datepickerakhir" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <button type="submit" id="cetakdetailsuratsakit" class="btn btn-secondary">Cetak &nbsp;<i class="fas fa-print"></i></button>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!-- /.card-body -->
          </form>
        </div>
      </div>
    </div>
      </div>
    </div>
</div>
<!-- Modal Surat Sakit-->

<!-- Modal Surat Sehat-->
<div class="modal fade" id="modal-detail-sehat">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="row">
      <!-- left column -->
      <div class="col-md-12">
      <!-- jquery validation -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Cetak Surat Keterangan Berbadan Sehat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" id="cetaksuratsehat" method="post" action="{{url('cetaksuratsehat')}}" >
            {{ csrf_field() }}
            <input type="hidden" name="id_header_sehat" class="form-control" id="txtIDHeaderSehat"></input>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                    <div class="form-group">
                      <label>Keperluan</label>
                      <div class="row">
                         <div class="col-md-12">
                           <div class="row">
                              <div class="col-md-10">
                                <div class="input-group date">
                                    <input type="text" name="keperluan" class="form-control{{ $errors->has('keperluan') ? ' is-invalid' : '' }}" id="txtKeperluan" value="{{old('keperluan') }}" placeholder="Keperluan">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <button type="submit" id="cetakdetailsuratsakit" class="btn btn-secondary">Cetak &nbsp;<i class="fas fa-print"></i></button>
                              </div>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <!--<div class="card-footer float-right">
               <button type="submit" id="cetakdetailsuratsehat" class="btn btn-secondary">Cetak &nbsp;<i class="fas fa-print"></i></button>
          </div>-->
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Surat Sehat-->

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

    //datepicker
    $('#datepicker2').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    })

    $('#datepickerawal').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    })

    $('#datepickerakhir').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    })

    $('#cetaksuratsehat').validate({
      rules: {
        keperluan: {
          required: true
        },
      },
      messages: {
        nama: {
          keperluan: "Keperluan harus diisi.",
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });

   });
  </script>
  <script type="text/javascript">
    function changeIDRMSakit(id_rekammedis)
    {
      //alert(id_rekammedis);

      if(id_rekammedis!="")
      {
         $("#txtIDHeaderSakit").val(id_rekammedis);
      }
      else
      { 
         $("#txtIDHeaderSakit").val("");
      }
    }

    function changeIDRMSehat(id_rekammedis)
    {
      //alert(id_rekammedis);

      if(id_rekammedis!="")
      {
         $("#txtIDHeaderSehat").val(id_rekammedis);
      }
      else
      { 
         $("#txtIDHeaderSehat").val("");
      }
    }
  </script>
@endsection
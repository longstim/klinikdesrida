@extends('layouts.dashboard')
@section('page_heading','Pemeriksaan')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Pemeriksaan</li>
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

      <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:30%">NRM</th>
            <td>{{$pasienberobat->id}}</td>
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

      <form role="form" id="pemeriksaanpasien" method="post" action="{{url('prosespemeriksaanpasien')}}" >
        {{ csrf_field() }}
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Rekam Medis</h3>
        </div>
        <input type="hidden" name="id" class="form-control" id="txtID" value="{{$pasienberobat->id}}"></input>
  
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                  <th style="width:30%">Keluhan</th>
                  <td>:</td>
                  <td><textarea name="keluhan" class="form-control" id="txtKeluhan" rows="2" placeholder="Keluhan"></textarea></td>
                </tr>
                <tr>
                  <th style="width:30%">Diagnosa</th>
                   <td>:</td>
                  <td><input type="text" name="diagnosa" class="form-control{{ $errors->has('diagnosa') ? ' is-invalid' : '' }}" id="txtDiagnosa" value="{{old('diagnosa') }}" placeholder="Diagnosa"></td>
                </tr>
                <tr>
                  <th style="width:30%">Alergi</th>
                  <td>:</td>
                  <td><textarea name="alergi" class="form-control" id="txtAlergi" rows="2" placeholder="Alergi"></textarea></td>
                </tr>
                <tr>
                  <th style="width:30%">Catatan</th>
                  <td>:</td>
                  <td><textarea name="catatan" class="form-control" id="txtCatatan" rows="2" placeholder="Catatan"></textarea></td>
                </tr>
                <tr>
                    <th style="width:30%">Tensi</th>
                    <td>:</td>
                    <td>
                      <div class="row">
                        <div class="input-group col-md-6">
                          <input type="text" name="tensi" class="form-control{{ $errors->has('tensi') ? ' is-invalid' : '' }}" id="txtTensi" value="{{old('tensi') }}" placeholder="Tensi">
                          <div class="input-group-prepend">
                            <span class="input-group-text">mmHg</span>
                          </div>
                        </div>
                      </div>
                    </td>
                </tr>
                <tr>
                  <th style="width:30%">Tinggi Badan</th>
                  <td>:</td>
                  <td>
                    <div class="row">
                      <div class="input-group col-md-6">
                        <input type="text" name="tinggi" class="form-control{{ $errors->has('tinggi') ? ' is-invalid' : '' }}" id="txtTinggi" value="{{old('tinggi') }}" placeholder="Tinggi Badan">  
                        <div class="input-group-prepend">
                            <span class="input-group-text">&nbsp;&nbsp;&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th style="width:30%">Berat Badan</th>
                  <td>:</td>
                  <td>
                    <div class="row">
                      <div class="input-group col-md-6">
                        <input type="text" name="berat" class="form-control{{ $errors->has('berat') ? ' is-invalid' : '' }}" id="txtBerat" value="{{old('berat') }}" placeholder="Berat Badan">  
                        <div class="input-group-prepend">
                            <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;Kg&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th style="width:30%">Temperatur</th>
                  <td>:</td>
                  <td>
                    <div class="row">
                      <div class="input-group col-md-6">
                        <input type="text" name="temperatur" class="form-control{{ $errors->has('temperatur') ? ' is-invalid' : '' }}" id="txtTemperatur" value="{{old('temperatur') }}" placeholder="Temperatur">  
                        <div class="input-group-prepend">
                            <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;°C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th style="width:30%">Obat</th>
                  <td>:</td>
                  <td>  <textarea name="obat" class="form-control" id="txtObat" rows="2" placeholder="Obat"></textarea></td>
                </tr>
                <tr>
                  <th style="width:30%">Harga</th>
                  <td>:</td>
                  <td>
                    <div class="row">
                      <div class="input-group col-md-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" name="harga" class="form-control{{ $errors->has('harga') ? ' is-invalid' : '' }}" id="txtHarga" value="{{old('harga') }}" placeholder="Harga">
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </div>
      
      </form>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>

  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script>
    $( document ).ready(function () {

       $('#pemeriksaanpasien').validate({
      rules: {
        keluhan: {
          required: true
        },
        diagnosa: {
          required: true
        },
        alergi: {
          required: true
        },
        catatan: {
          required: true
        },
        tensi: {
          required: true
        },
        tinggi: {
          required: true
        },
        berat: {
          required: true
        },
        temperatur: {
          required: true
        },
        obat: {
          required: true
        },
        harga: {
          required: true
        },
      },
      messages: {
        keluhan: {
          required: "Keluhan harus diisi."
        },
        diagnosa: {
          required: "Diagnosa harus diisi."
        },
        alergi: {
          required: "Alergi harus diisi."
        },
        catatan: {
          required: "Catatan harus diisi."
        }, 
        tensi: {
          required: "Tensi harus diisi."
        },
        tinggi: {
          required: "Tinggi harus diisi."
        },
        berat: {
          required: "Berat harus diisi."
        },
        temperatur: {
          required: "Temperatur harus diisi."
        },
        obat: {
          required: "Obat harus diisi."
        },
        harga: {
          required: "Harga harus diisi."
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
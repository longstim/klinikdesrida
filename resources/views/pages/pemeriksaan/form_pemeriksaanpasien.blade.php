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

  #addDropDownDiagnosa .table td
  {
    padding: 0 rem;
  }
</style>
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <div class="row">
    <div class="col-12">
      <div>
        @if(Session::has('message'))
            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
        @endif
      </div>
  <form role="form" id="pemeriksaanpasien" method="post" action="{{url('prosespemeriksaanpasien')}}" >
        {{ csrf_field() }}
    <div class="row">
      <div class="col-md-6">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tr>
                <th>NRM</th>
                 <td>:</td>
                <td>{{$pasienberobat->id}}</td>
              </tr>
              <tr>
                <th>Nama</th>
                 <td>:</td>
                <td>{{$pasien->nama}}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                 <td>:</td>
                <td>{{$pasien->alamat}}</td>
              </tr>
              <tr>
                <th>No. HP</th>
                 <td>:</td>
                <td>{{$pasien->no_hp}}</td>
              </tr>
            </table>
        </div>
      </div>
      <div class="col-md-6">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tr>
                <th>Tensi</th>
                <td>:</td>
                <td>
                  <div class="row">
                    <div class="input-group col-md-12">
                      <input type="text" name="tensi" class="form-control" id="txtTensi" value="{{$rekam_medis[0]['tensi']}}" placeholder="Tensi">
                      <div class="input-group-prepend">
                        <span class="input-group-text">mmHg</span>
                      </div>
                    </div>
                  </div>
                </td>
            </tr>
            <tr>
              <th>Tinggi Badan</th>
              <td>:</td>
              <td>
                <div class="row">
                  <div class="input-group col-md-12">
                    <input type="text" name="tinggi" class="form-control" id="txtTinggi" value="{{$rekam_medis[0]['tinggi']}}" placeholder="Tinggi">
                    <div class="input-group-prepend">
                        <span class="input-group-text">&nbsp;&nbsp;&nbsp;cm&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <th>Berat Badan</th>
              <td>:</td>
              <td>
                <div class="row">
                  <div class="input-group col-md-12">
                    <input type="text" name="berat" class="form-control" id="txtBerat" value="{{$rekam_medis[0]['berat']}}" placeholder="Berat">  
                    <div class="input-group-prepend">
                        <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;Kg&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <th>Temperatur</th>
              <td>:</td>
              <td>
                <div class="row">
                  <div class="input-group col-md-12">
                    <input type="text" name="temperatur" class="form-control" id="txtTemperatur" value="{{$rekam_medis[0]['temperatur']}}" placeholder="Temperatur">  
                    <div class="input-group-prepend">
                        <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;°C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
                <th>Alergi</th>
                <td>:</td>
                <td><textarea name="alergi" class="form-control" id="txtAlergi" rows="2" placeholder="Alergi">{{$rekam_medis[0]['alergi']}}</textarea></td>
            </tr>
            </table>
        </div>
      </div>
    </div>
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
                  <td>
                    <div class="row" id="DropDownDiagnosa">
                      <div class="input-group col-md-12">
                        <select name="diagnosa[]" id="id_diagnosa" class="form-control select2bs4" multiple="multiple" style="width: 100%;" data-placeholder="Diagnosa">
                          @foreach($diagnosa as $data)
                              <option value="{{$data->id}}">{{$data->category.' - '.$data->indonesian_name}}</option>
                          @endforeach
                        </select>  
                      </div>
                      <!--<div class="input-group-prepend">
                          <a class="btn btn-success btn-sm" id="btnAdd" href="#DropDownDiagnosa"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>
                      </div>-->
                    </div>
                  </td>
                </tr>
                <!--<tr>
                   <th style="width:30%"></th>
                   <td></td>
                   <td>
                      <table style="width:100%;margin-left:-12px;" id="addDropDownDiagnosa">
                      </table>
                   </td>
                </tr>-->
                <tr>
                  <th style="width:30%">Catatan</th>
                  <td>:</td>
                  <td><textarea name="catatan" class="form-control" id="txtCatatan" rows="2" placeholder="Catatan"></textarea></td>
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
  <!-- Select2 -->
  <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
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
          required: true,
          number:true
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
          required: "Harga harus diisi.",
          number: "Harga harus diisi dengan angka.",
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
  <script type="text/javascript">

    $('#btnAdd').bind('click', function(){
        addRow();
    });

    function addRow()
    {
       var tr = '<tr>'+
                   '<td>'+
                      '<div class="row">'+
                        '<div class="input-group col-md-10">'+
                          '<select name="diagnosa[]" id="id_diagnosa" class="form-control select2bs4" style="width: 100%;">'+
                            '<option value="" selected="selected">-- Pilih Satu --</option>'+
                            '@foreach($diagnosa as $data)'+
                                '<option value="{{$data->id}}">{{$data->indonesian_name}}</option>'+
                            '@endforeach'+
                          '</select>'+  
                        '</div>'+
                       /* '<div class="input-group-prepend">'+
                            '<a class="btn btn-danger btn-sm" id="btnRemove[]" href="#DropDownDiagnosa"><i class="fa fa-minus fa-2x" aria-hidden="true"></i></a>'+
                        '</div>'+*/
                      '</div>'+
                    '</td>'+
                 '</tr>';
        
        $('#addDropDownDiagnosa').append(tr);

        $('#btnRemove').bind('click', '.remove', function(){
            $(this).parent().parent().remove();
        });
    }
  </script>
@endsection
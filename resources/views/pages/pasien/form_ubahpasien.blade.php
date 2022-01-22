@extends('layouts.dashboard')
@section('page_heading','Pasien')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('pasien')}}">Pasien</a></li>
  <li class="breadcrumb-item active">Edit Pasien</li>
</ol>
@endsection
@section('content')
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
	<!-- jquery validation -->
		<div class="card card-success">
		  <div class="card-header">
		    <h3 class="card-title">Edit Data</h3>
		  </div>
	      <div>
	        @if(Session::has('message'))
	            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
	            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
	        @endif
	      </div>
		  <!-- /.card-header -->
		  <!-- form start -->
		  <form role="form" id="ubahpasien" method="post" action="{{url('prosesubahpasien')}}">
		  	{{ csrf_field() }}
 
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
				    	 <input type="hidden" name="id" class="form-control" id="txtID" value="{{$pasien->id}}"></input>

	            <div class="form-group">
				        <label>Nama Pasien</label>
				        <input type="text" name="nama" class="form-control" id="txtNama" value="{{$pasien->nama}}" placeholder="Nama Pasien">
				      </div>
				      <div class="form-group">
				        <label>Tanggal Lahir</label>
				        <div class="input-group date">
	                  <input type="text" name="tanggal_lahir" class="form-control" id="datepicker" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime($pasien->tanggal_lahir))}}">
	                  <div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	                  </div>
	               </div>
			      	</div>
			      	<div class="form-group">
				        <label>Nomor HP</label>
				        <input type="text" name="no_hp" class="form-control" id="txtNoHP" value="{{$pasien->no_hp}}" placeholder="Nomor HP">
				      </div>
				      <div class="form-group">
					      	<label>Alamat</label>
					        <textarea name="alamat" class="form-control" id="txtAlamat" rows="2" placeholder="Alamat">{{$pasien->alamat}}</textarea>
					    </div>
			        <div class="form-group">
				        <label>Jenis Kelamin</label>
				         <select name="jenis_kelamin" id="id_jenis_kelamin" class="form-control select2bs4" style="width: 100%;">
	                    <option value="" selected="selected">-- Pilih Satu --</option>
	                    <option value="Pria" @if($pasien->jenis_kelamin == "Pria") selected @endif>Pria</option>
	                    <option value="Wanita" @if($pasien->jenis_kelamin == "Wanita") selected @endif>Wanita</option>
	                </select>
				      </div>
				     	<div class="form-group">
				        <label>Nama Orang Tua</label>
				        <input type="text" name="nama_orangtua" class="form-control" id="txtNamaOrangtua" value="{{$pasien->nama_orangtua}}" placeholder="Nama Orang Tua">
				      </div>
						</div>
					</div>
			</div>
			<!-- /.card-body -->

		    <div class="card-footer">
		      <button type="submit" class="btn btn-success">Simpan</button>
		    </div>
	  	</form>
		</div>
	</div>
</div>


<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {

	  $('#ubahpasien').validate({
	    rules: {
		     nama: {
	        required: true
	      },
	      tanggal_lahir: {
	        required: true
	      },
	      no_hp: {
	        required: true
	      },
	      alamat: {
	        required: true
	      },
	      jenis_kelamin: {
	        required: true
	      },
	      nama_orangtua: {
	        required: true
	      },
	    },
	    messages: {
	      nama: {
	        required: "Nama harus diisi."
	      },
	      tanggal_lahir: {
	        required: "Tanggal Lahir harus diisi."
	      },
	      no_hp: {
	        required: "Nomor HP harus diisi."
	      },
	      alamat: {
	        required: "Alamat harus diisi."
	      }, 
	      jenis_kelamin: {
	        required: "Jenis Kelamin harus dipilih."
	      },
	      nama_orangtua: {
	        required: "Nama Orang Tua harus diisi."
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
      $("#detailtable").DataTable({
        "paging": true,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": true,
	      "info": true,
	      "autoWidth": false,
	      "responsive": true,
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

	});

	$(function () {
  	bsCustomFileInput.init();
	});

</script>
@endsection
@extends('layouts.dashboard')
@section('page_heading','Pasien')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('pasien')}}">Pasien</a></li>
  <li class="breadcrumb-item active">Tambah Pasien</li>
</ol>
@endsection
@section('content')
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
	<!-- jquery validation -->
		<div class="card card-success">
		  <div class="card-header">
		    <h3 class="card-title">Tambah Data</h3>
		  </div>
	      <div>
	        @if(Session::has('message'))
	            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
	            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
	        @endif
	      </div>
		  <!-- /.card-header -->
		  <!-- form start -->
		  <form role="form" id="tambahpasien" method="post" action="{{url('prosestambahpasien')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
				      <div class="form-group">
				        <label>Nama Pasien</label>
				        <input type="text" name="nama" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" id="txtNama" value="{{old('nama') }}" placeholder="Nama Pasien">
				      </div>
				      <div class="form-group">
				        <label>Tanggal Lahir</label>
				        <div class="input-group date">
	                  <input type="text" name="tanggal_lahir" class="form-control" id="datepicker" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
	                  <div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	                  </div>
	               </div>
			      	</div>
			      	<div class="form-group">
				        <label>Nomor HP</label>
				        <input type="text" name="no_hp" class="form-control{{ $errors->has('no_hp') ? ' is-invalid' : '' }}" id="txtNoHP" value="{{old('no_hp') }}" placeholder="Nomor HP">
				      </div>
				      <div class="form-group">
					      	<label>Alamat</label>
					        <textarea name="alamat" class="form-control" id="txtAlamat" rows="2" placeholder="Alamat"></textarea>
					    </div>
			        <div class="form-group">
				        <label>Jenis Kelamin</label>
				         <select name="jenis_kelamin" id="id_jenis_kelamin" class="form-control select2bs4" style="width: 100%;">
	                    <option value="" selected="selected">-- Pilih Satu --</option>
	                    <option value="Pria">Pria</option>
	                    <option value="Wanita">Wanita</option>
	                </select>
				      </div>
				      <div class="form-group">
					      	<label>Riwayat Alergi</label>
					        <textarea name="riwayat_alergi" class="form-control" id="txtRiwayatAlergi" rows="2" placeholder="Riwayat Alergi"></textarea>
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
        <!-- /.row -->
	</div>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {
	  $('#tambahpasien').validate({
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
	      riwayat_alergi: {
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
	      riwayat_alergi: {
	        required: "Riwayat Alergi harus diisi."
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
</script>
@endsection
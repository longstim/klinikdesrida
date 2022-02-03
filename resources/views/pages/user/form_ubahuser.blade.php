@extends('layouts.dashboard')
@section('page_heading','User')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('user')}}">User</a></li>
  <li class="breadcrumb-item active">Edit User</li>
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
		  <form role="form" id="ubahuser" method="post" action="{{url('prosesubahuser')}}">
		  	{{ csrf_field() }}
 
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
				    	 <input type="hidden" name="id" class="form-control" id="txtID" value="{{$user->id}}"></input>

	            <div class="form-group">
				        <label>Nama</label>
				        <input type="text" name="nama" class="form-control" id="txtNama" value="{{$user->name}}" placeholder="Nama">
	               @if ($errors->has('nama'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nama') }}</strong>
                    </span>
	               @endif
				      </div>
			      	<div class="form-group">
				        <label>Username</label>
				        <input type="text" name="username" class="form-control" id="txtUsername" value="{{$user->username}}" placeholder="Username" readonly autofocus>
				         @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
	               @endif
				      </div>
				      <div class="form-group">
				        <label>Email</label>
				        <input type="email" name="email" class="form-control" id="txtEmail" value="{{$user->email}}" placeholder="Email">
				         @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
	               @endif
				      </div>
			        <div class="form-group">
				        <label>Role</label>
				         <select name="role" id="id_role" class="form-control select2bs4" style="width: 100%;">
	                    <option value="" selected="selected">-- Pilih Satu --</option>
	                    <option value="admin" @if($user->role == "admin") selected @endif>Administrator</option>
	                    <option value="dokter" @if($user->role == "dokter") selected @endif>Dokter</option>
	                    <option value="resepsionis" @if($user->role == "resepsionis") selected @endif>Suster</option>
	                </select>
	               @if ($errors->has('role'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('role') }}</strong>
                    </span>
	               @endif
				      </div>
				     	<div class="form-group">
	                  <label>Password Baru</label>
	                  <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
	                  @if ($errors->has('password'))
	                      <span class="invalid-feedback" role="alert">
	                          <strong>{{ $errors->first('password') }}</strong>
	                      </span>
	                  @endif
	            </div>
	             <div class="form-group">
	                  <label>Konfirmasi Password Baru</label>
	                  <input id="password-confirm" type="password" placeholder="Konfirmasi Password"class="form-control" name="password_confirmation">
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

	  $('#ubahuser').validate({
	    rules: {
		     nama: {
	        required: true
	      },
	      username: {
	        required: true
	      },
	      role: {
	        required: true
	      },
	      email: {
	        required: true
	      },
	    },
	    messages: {
	      nama: {
	        required: "Nama harus diisi."
	      },
	      username: {
	        required: "Username harus diisi."
	      },
	      role: {
	        required: "Role harus dipilih."
	      },
	      email: {
	        required: "Email harus diisi."
	      }, 
	      password: {
	        required: "Password harus diisi."
	      },
	      password_confirmation: {
	        required: "Konfirmasi Password harus diisi."
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
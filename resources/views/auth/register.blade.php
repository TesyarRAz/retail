@extends('layouts.customer')

@section('content')

<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-lg-8 col-md-10">
			<form class="p-3 border" action="{{ route('postRegister') }}" method="post" autocomplete="off">
				@csrf

				<h4 class="fw-bold">Register</h4>

				<div class="border-top">
					<div class="my-2">
						<label class="form-label">Name</label>
						<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
						@error('name')
							<div class="invalid-feedback">
				        		{{ $message }}
				      		</div>
						@enderror
					</div>
					<div class="my-2">
						<label class="form-label">Email</label>
						<input type="text" name="email" class="form-control @error('email') is-invalid @enderror" required>
						@error('email')
							<div class="invalid-feedback">
				        		{{ $message }}
				      		</div>
						@enderror
					</div>
					<div class="my-2">
						<label class="form-label">Username</label>
						<input type="text" name="username" class="form-control @error('username') is-invalid @enderror" required>
						@error('username')
							<div class="invalid-feedback">
				        		{{ $message }}
				      		</div>
						@enderror
					</div>
					<div class="my-2">
						<label class="form-label">Password</label>
						<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
						@error('password')
							<div class="invalid-feedback">
				        		{{ $message }}
				      		</div>
						@enderror
					</div>
					<a class="text-decoration-none" href="{{ route('login') }}">Sudah punya akun</a>

					<div class="d-flex justify-content-end my-3">
						<button type="submit" class="btn btn-sm btn-success">Login</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
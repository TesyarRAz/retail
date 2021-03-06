@extends('layouts.customer')

@section('content')

<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-lg-8 col-md-10">
			<form class="p-3 border bg-white" action="{{ route('postLogin') }}" method="post" autocomplete="off">
				@csrf

				<h4 class="fw-bold">Login</h4>

				<div class="border-top">
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
					<a class="text-decoration-none" href="{{ route('register') }}">Belum punya akun</a>

					<div class="my-2">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="remember_me" value="1" id="remember_me">
							<label class="form-check-label" for="remember_me">
								Remember me
							</label>
						</div>
					</div>

					<div class="d-flex justify-content-end my-3">
						<button type="submit" class="btn btn-sm btn-success">Login</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
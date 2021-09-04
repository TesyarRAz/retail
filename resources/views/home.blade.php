@extends('layouts.customer')

@section('title', config('app.name'))

@section('content')

<!-- carosel -->
<div class="container mt-3">
	<div class="row">
		<div id="carousel" class="carousel slide col-lg-8" data-bs-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active ">
					<img src="{{ asset('assets/images/crouser-1.jpg') }}" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
					<img src="{{ asset('assets/images/crouser-2.jpg') }}" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
					<img src="{{ asset('assets/images/crouser-3.jpg') }}" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
					<img src="{{ asset('assets/images/crouser-4.jpg') }}" class="d-block w-100" alt="...">
				</div>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
		<div class="col-4">
			<div>
				<img src="{{ asset('assets/images/crouser-3.jpg') }}" class="d-none d-lg-block w-100" alt="">
			</div>
			<div>
				<img src="{{ asset('assets/images/crouser-4.jpg') }}" class="d-none d-lg-block mt-2 w-100" alt="">
			</div>
		</div>
	</div>

	<!-- Kategori -->
	<div class="card mt-4 shadow">
		<div class="card-body">
			<span class="card-title fw-bold h4">Kategori</span>
			<hr>

			<div class="row align-items-center mt-3">
				@foreach ($kategoris as $item)
				<div class="col-lg-2 col-md-4 col-sm-6 mb-2">
					<a href="{{ route('customer.produk.index', ['kategori' => $item->name]) }}" class="fw-bold btn btn-lg btn-success">{{ $item->name }}</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>

	<!-- Terlaris -->
	<div class="my-3">
		<div class="row">
			<div class="col-2">
				<h4 class="fw-bold">Terlaris</h4>
			</div>
			<div class="col-10">
				<hr>
			</div>
		</div>
		<div class="row align-items-center">
			<div class="col-lg-2 col-md-4 col-sm-6 d-none d-lg-block">
				<img src="{{ asset('assets/images/iklan.jpg') }}" alt="">
			</div>
			@foreach ($terlaris as $item)
			<div class="col-lg-3 col-md-4 col-sm-6">
				<a href="{{ route('customer.produk.show', $item->id) }}" class="text-reset text-decoration-none">
					<div class="card shadow">
						<img class="card-img-top" src="{{ $item->image }}" width="200" height="200" alt="">
						<div class="card-body">
							<span class="badge small bg-success">{{ $item->kategori->name }}</span>
							<span class="text-break d-block">{{$item->name }}</span>
							<span class="card-subtitle fw-bold">Rp. {{ number_format($item->price, 0, ',', '.') }}</span>
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>

	<!-- Terbaru -->
	<div class="my-3">
		<div class="row">
			<div class="col-2">
				<h4 class="fw-bold">Terbaru</h4>
			</div>
			<div class="col-10">
				<hr>
			</div>
		</div>
		<div class="row align-items-center">
			<div class="col-lg-2 col-md-4 col-sm-6 d-none d-lg-block">
				<img src="{{ asset('assets/images/iklan-2.jpg') }}" alt="">
			</div>
			@foreach ($terbaru as $item)
			<div class="col-lg-3 col-md-4 col-sm-6">
				<a href="{{ route('customer.produk.show', $item->id) }}" class="text-reset text-decoration-none">
					<div class="card shadow">
						<img class="card-img-top" src="{{ $item->image }}" width="200" height="200" alt="">
						<div class="card-body">
							<span class="badge small bg-success">{{ $item->kategori->name }}</span>
							<span class="text-break d-block">{{$item->name }}</span>
							<span class="card-subtitle fw-bold">Rp. {{ number_format($item->price, 0, ',', '.') }}</span>
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</div>



<footer class="text-center mt-3 mb-3 fw-bold">
	Copyright &copy; MBCorp 2021
</footer>

@endsection
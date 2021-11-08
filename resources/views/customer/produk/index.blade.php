@extends('layouts.customer')

@section('title', config('app.name') . ' - Produk')

@section('content')

<div class="container">
	<div class="card">
		<div class="card-body">
			@if (request()->has('search'))
			<h4 class="fw-bold">Hasil Pencarian: {{ request('search') }}</h4>
			<hr>
			@endif

			@if (request()->has('kategori'))
			<h4 class="fw-bold">Kategori : {{ request('kategori') }}</h4>
			<hr>
			@endif
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			@if(!$data->isEmpty())
			<div class="row align-items-center">
				@foreach ($data as $item)
				<div class="col-lg-2 col-md-3 col-sm-6">
					<a href="{{ route('customer.produk.show', $item->id) }}" class="text-reset text-decoration-none">
						<div class="card shadow">
							<img class="card-img-top" src="{{ $item->image }}" width="150" height="150" alt="">
							<div class="card-body">
								<span class="badge small bg-success text-wrap">{{ $item->kategori->name }}</span>
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

	<div class="d-flex justify-content-end">
		{{ $data->render() }}
	</div>
	@else
	<h5 class="fw-bold">Tidak ada produk</h5>
	@endif
</div>

@endsection
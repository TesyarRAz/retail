@extends('layouts.customer')

@section('title', config('app.name') . ' - Produk')

@section('content')

<div class="container">
	@if (request()->has('search'))
		<h4 class="fw-bold">Hasil Pencarian: {{ request('search') }}</h4>
		<hr>
	@endif

	@if (request()->has('kategori'))
		<h4 class="fw-bold">Kategori : {{ request('kategori') }}</h4>
		<hr>
	@endif

	@if(!$data->isEmpty())
	<div class="row align-items-center">
		@foreach ($data as $item)
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

	<div class="d-flex justify-content-end">
		{{ $data->render() }}
	</div>
	@else
	<h5 class="fw-bold">Tidak ada produk</h5>
	@endif
</div>

@endsection
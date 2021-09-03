@extends('layouts.customer')

@section('title', config('app.name') . ' - Keranjang')

@section('content')

<div class="container">
	<h4>Keranjang</h4>
	<hr>

	@foreach ($keranjangs as $item)
		<div class="card shadow">
			<div class="card-body">
				<div class="row">
					<div class="col-3">
						<img src="{{ \Storage::disk('public')->url($item->produk->image) }}" class="img-fluid rounded">
					</div>
					<div class="col">
						<div class="d-flex justify-content-between mb-5 align-items-center">
							<div>
								<span class="d-block small">{{ $item->produk->name }}</span>
								<span class="fw-bold small">Rp. {{ number_format($item->produk->price, 0, ',', '.') }}</span>
							</div>
							<span class="fw-bold">X {{ $item->qty }}</span>
						</div>

						<div class="d-flex justify-content-between align-items-center">
							<div>
								<span class="d-block">Total Harga</span>
								<span class="fw-bold d-block fs-5">Rp. {{ number_format($item->price_total, 0, ',', '.') }}</span>
							</div>
							<form action="{{ route('customer.keranjang.destroy', $item->id) }}" method="post">
								@csrf
								@method('delete')

								<button type="submit" class="btn btn-danger">
									<i class="fas fa-fw fa-trash"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>

@endsection
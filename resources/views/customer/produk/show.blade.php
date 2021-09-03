@extends('layouts.customer')

@section('title', config('app.name') . ' - ' . $produk->name)

@section('content')

<div class="container">
	<form class="mt-5" action="{{ route('customer.produk.store') }}" method="POST">
		@csrf

		<input type="hidden" name="produk_id" value="{{ $produk->id }}">

		<div class="row">
			<div class="col-lg-8">
				<div class="row">
					<div class="col-md-6">
						<img src="{{ \Storage::disk('public')->url($produk->image) }}" class="img-thumbnail">
					</div>
					<div class="col-md-6">
						<span class="badge bg-primary">{{ $produk->kategori->name }}</span>
						<h4 class="fw-bold mt-2">{{ $produk->name }}</h4>
						<hr>

						<span class="text-break">Harga</span>
						<span class="fw-bold d-block text-danger fs-4">{{ number_format($produk->price, 0, ',', '.') }}</span>
						<p>{{ $produk->description }}</p>
						<hr>

						<span class="mt-1 text-muted">Jumlah yang ingin dibeli</span>

						<div class="mt-2 d-flex w-50">
							<button type="button" class="btn btn-sm btn-primary me-2" onclick="decrementQty()">
								<span class="fw-bold fs-5">-</span>
							</button>
							<input class="form-control form-control-sm text-center" type="number" name="qty" id="qty" value="1" required>
							<button type="button" class="btn btn-sm btn-primary ms-2" onclick="incrementQty()">
								<span class="fw-bold fs-5">+</span>
							</button>
						</div>

						<div class="mt-5">
							<button class="btn btn-sm btn-success" name="type" value="checkout">Beli Sekarang</button>
							<button class="btn btn-sm btn-outline-primary" name="type" value="keranjang">Masukan ke Keranjang</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 mt-5 mt-lg-0">
				<div class="card">
					<div class="card-body">
						<span class="fw-bold">Penjual</span>
						<hr>

						<div class="text-center">
							<div class="badge bg-primary">
								<span class="h5 fw-bold">BDP</span>
							</div>
						</div>

						<div class="mt-5">
							<button class="btn btn-sm btn-outline-success w-100">
								Info
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

</div>

@endsection

@push('js')
<script type="text/javascript">
	let qty = document.querySelector("#qty");
	window.decrementQty = () => {
		qty.value = parseInt(qty.value || 0) - 1;
	}
	window.incrementQty = () => {
		qty.value = parseInt(qty.value || 0) + 1;
	}
</script>
@endpush
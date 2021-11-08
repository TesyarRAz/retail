@extends('layouts.customer')

@section('title', config('app.name') . ' - ' . $produk->name)

@section('content')

<div class="container">
	<form class="mt-5" action="{{ route('customer.produk.store') }}" method="POST">
		@csrf

		<input type="hidden" name="produk_id" value="{{ $produk->id }}">

		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<div class="row">
					<div class="col-md-6">
						<div class="d-flex justify-content-center align-items-center h-100">
							<img src="{{ $produk->image }}" style="min-width: 200px; min-height: 200px;" class="img-thumbnail">
						</div>
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

						<div class="mt-2 d-flex w-50" x-data="{ qty: 1 }">
							<button type="button" class="btn btn-sm btn-primary me-2" x-on:click="qty--">
								<span class="fw-bold fs-5">-</span>
							</button>
							<input class="form-control form-control-sm text-center" type="number" name="qty" x-model="qty" required>
							<button type="button" class="btn btn-sm btn-primary ms-2" x-on:click="qty++">
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
				</div>
			</div>
			<div class="col-lg-4 mt-5 mt-lg-0">
				<div class="card">
					<div class="card-body">
						<span class="fw-bold">Penjual</span>
						<hr>

						<div class="kategori-card p-2 rounded-3 mx-auto">
							<div class="d-flex flex-column align-items-center justify-content-center h-100">
								<img src="{{ $produk->kategori->gambar }}" width="100" height="100">
								<div class="fw-bold text-center">
									<span class="small">{{ $produk->kategori->name }}</span>
								</div>
							</div>
						</div>

						<div class="mt-5">
							<a href="{{ route('customer.produk.index', ['kategori' => $produk->kategori->name]) }}" class="btn btn-sm btn-outline-success w-100">
								Info
							</a>
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
<script src="//unpkg.com/alpinejs"></script>
{{-- <script type="text/javascript">
	let qty = document.querySelector("#qty");
	window.decrementQty = () => {
		qty.value = parseInt(qty.value || 0) - 1;
	}
	window.incrementQty = () => {
		qty.value = parseInt(qty.value || 0) + 1;
	}
</script> --}}
@endpush
@extends('layouts.customer')

@section('title', config('app.name') . ' - Invoice')

@section('content')

<div class="container">
	<h4>Invoice - {{ $transaksi->invoice }}</h4>
	<hr>

	@if(filled($transaksi->keterangan_ditolak))
	<div class="alert alert-danger">
		Alasan ditolak : {{ $transaksi->keterangan_ditolak }}
	</div>
	@endif

	@foreach ($transaksi->details as $item)
		<div class="card shadow">
			<div class="card-body">
				<div class="row">
					<div class="col-2">
						<img src="{{ $item->produk->image }}" class="img-fluid rounded" width="150" height="150">
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
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach

	<hr>
	<span class="d-block">Total</span>
	<span class="fw-bold">Rp. {{ number_format($transaksi->details->sum('price_total'), 0, ',', '.') }}</span>

	@if (!$transaksi->selesai)
	<form class="my-5" action="{{ route('customer.keranjang.update', $transaksi->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		@method('put')
		
		<h4>Upload Bukti Pembayaran</h4>
		<hr>
		<p>Silahkan lakukan pembayaran ke no rek berikut ini 0000000 atau lakukan pembayaran langsung</p>
		<div class="mb-2" >
			<label class="fw-bold form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
			<input type="file" name="bukti_transaksi" class="form-control" accept="image/*" required>
		</div>
		<div class="d-flex justify-content-end">
			<button class="btn btn-success">Upload</button>
		</div>
	</form>
	@endif
</div>

@endsection
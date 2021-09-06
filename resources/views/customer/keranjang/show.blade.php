@extends('layouts.customer')

@section('title', config('app.name') . ' - Invoice')

@section('content')

<div class="container">
	<div class="d-flex align-items-center justify-content-between">
		<div>
			<a href="{{ route('customer.keranjang.index', ['type' => 'checkout']) }}" class="btn btn-sm btn-primary">
				<i class="fas fa-fw fa-arrow-left"></i>
			</a>
			<span class="fs-4 ms-2">Invoice - {{ $transaksi->invoice }}</span>
		</div>
		<div>
			{{-- <form action="{{ route('customer.keranjang.destroy', $transaksi->id) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus transaksi?')">
				@csrf
				@method('delete')

				<button type="submit" class="btn btn-sm btn-danger" {{ $transaksi->selesai ? 'disabled' : '' }}>
					<i class="fas fa-fw fa-trash"></i>
				</button>
			</form> --}}
		</div>
	</div>
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
	<div>
		<span class="d-block">Total</span>
		<span class="fw-bold">Rp. {{ number_format($transaksi->details->sum('price_total'), 0, ',', '.') }}</span>
	</div>
	<div class="mt-2">
		<span class="d-block">Ongkos Kirim</span>
		<span class="fw-bold">
			@if (filled($transaksi->ongkir))
			Rp. {{ number_format($transaksi->ongkir, 0, ',', '.') }}
			@else
			Belum diatur admin
			@endif
		</span>
	</div>

	<div class="my-5">
		<h4>Metode Pengambilan Barang</h4>
		<hr>
		<div class="row">
			<div class="col-lg-2 col-md-4 col-sm-6">Jenis</div>
			<div class="col-auto fw-bold">
				{{ ucfirst($transaksi->jenis) }}
			</div>
		</div>
		<div class="row" @if ($transaksi->jenis == 'diambil') d-none @endif>
			<div class="col-lg-2 col-md-4 col-sm-6">Pengiriman</div>
			<div class="col-auto fw-bold">
				{{ $transaksi->pengiriman_via }}
			</div>
		</div>
		<div class="row" @if ($transaksi->jenis == 'diambil') d-none @endif>
			<div class="col-lg-2 col-md-4 col-sm-6">Alamat</div>
			<div class="col-auto fw-bold">
				{{ ucfirst($transaksi->alamat_pengiriman) }}
			</div>
		</div>
	</div>

	@if (!$transaksi->selesai && ($transaksi->jenis == 'diambil' || ($transaksi->jenis == 'dikirim' && filled($transaksi->ongkir))))
	<form class="my-5" action="{{ route('customer.keranjang.update', $transaksi->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		@method('put')

		<input type="hidden" name="type" value="bukti">
		
		<h4>Upload Bukti Pembayaran</h4>
		<hr>
		<p>Silahkan lakukan pembayaran ke no rek berikut ini 0000000 atau lakukan pembayaran langsung</p>
		<div class="mb-2" >
			<label class="fw-bold form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
			<input type="file" name="bukti_transaksi" class="form-control" accept="image/*" required>
		</div>
		<div class="d-flex justify-content-end">
			<button type="submit" class="btn btn-success">Upload</button>
		</div>
	</form>
	@endif
</div>

@endsection
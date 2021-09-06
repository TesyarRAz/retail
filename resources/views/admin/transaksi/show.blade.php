@extends('adminlte::page')

@section('content_header')
<h4>Detail Pembelian</h4>
@endsection

@section('content')

<div class="row">
	<div class="col-lg-7 mb-2">
		<div class="card shadow">
			<div class="card-body">
				<form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="post">
					@csrf
					@method('put')

					<input type="hidden" name="type" value="ongkir">

					<div class="d-flex justify-content-between">
						<div class="col-lg-4 col-md-6">
							<span>Metode Pengambilan</span>
						</div>
						<div class="col-lg-8 col-md-6">
							<span class="font-weight-bold">{{ ucfirst($transaksi->jenis) }}</span>
						</div>
					</div>
					<div class="@if ($transaksi->jenis == 'diambil') d-none @endif">
						<div class="d-flex justify-content-between">
							<div class="col-lg-4 col-md-6">
								<span>Jasa Pengiriman</span>
							</div>
							<div class="col-lg-8 col-md-6">
								<span class="font-weight-bold">{{ ucfirst($transaksi->pengiriman_via) }}</span>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="col-lg-4 col-md-6">
								<span>Alamat</span>
							</div>
							<div class="col-lg-8 col-md-6">
								<span class="font-weight-bold">{{ ucfirst($transaksi->alamat_pengiriman) }}</span>
							</div>
						</div>
						<hr>
						<div class="mx-2 form-group">
							<label>Ongkir</label>
							<input type="text" name="ongkir" value="{{ $transaksi->ongkir ?? 0 }}" class="form-control" data-mask="000.000.000.000" data-mask-reverse="true" required>
						</div>
						<div class="row mx-2 justify-content-end">
							<button type="submit" class="btn btn-sm btn-primary" @if($transaksi->selesai) disabled @endif>Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="invoice-print" class="col-lg-5 mb-5">
		<div class="card shadow text-monospace">
			<div class="card-body">
				<div class="text-center">
					<span class="font-weight-bold">Invoice</span>
					<span class="d-block">{{ $transaksi->invoice }}</span>
				</div>
				<hr>
				<div class="row mb-3 justify-content-between">
					<div class="col-6">
						Nama : <span class="font-weight-bold">{{ $transaksi->user->name }}</span>
					</div>
					<div class="col-6 text-right">
						<span>{{ $transaksi->created_at->format('d-m-Y') }}</span>
					</div>
				</div>
				<span class="small">Barang :</span>
				<div class="mt-2">
					@foreach ($transaksi->details as $detail)
					<div class="d-flex justify-content-between">
						<span>{{ $detail->produk->name }} x {{ $detail->qty }}</span>
						<span>Rp. {{ number_format($detail->price_total, 0, ',', '.') }}</span>
					</div>
					@endforeach

					@if ($transaksi->jenis == 'dikirim')
					<div class="d-flex justify-content-between">
						<span>Ongkir</span>
						<span>Rp. {{ number_format($transaksi->ongkir ?? 0, 0, ',', '.') }}</span>
					</div>
					@endif
				</div>
				<hr>
				<div class="d-flex justify-content-between">
					<span>Total</span>
					<span>Rp. {{ number_format($transaksi->price_total, 0, ',', '.') }}</span>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-end" id="buttonBar">
			<button class="btn btn-outline-success mr-2" type="button" onclick="invoicePrint()">Cetak</button>
			<form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="post" onsubmit="return confirm('Yakin ingin dikonfirmasi?')">
				@csrf
				@method('put')

				<input type="hidden" name="type" value="konfirmasi">

				<button type="submit" class="btn btn-success" {{ $transaksi->selesai || ($transaksi->jenis == 'dikirim' && blank($transaksi->ongkir)) ? 'disabled' : '' }}>Konfirmasi</button>
			</form>
		</div>
	</div>
</div>

@endsection

@push('js')
<script type="text/javascript">
	window.invoicePrint = () => {
		let oldElement = $("body").html();
		let newElement = $("#invoice-print").html();
		newElement = `<div class="row justify-content-center"><div class="col-8">${newElement}</div></div>`;

		$("body").html(newElement);
		$("#buttonBar").removeClass('d-flex');
		$("#buttonBar").addClass('d-none');
		window.print();

		$("body").html(oldElement);
		$("#buttonBar").addClass('d-flex');
		$("#buttonBar").removeClass('d-none');
	}
</script>
@endpush
@extends('adminlte::page')

@section('content_header')
<h4>Invoice Pembelian</h4>
@endsection

@section('content')

<div id="invoice-print">
	<div class="d-flex justify-content-center align-items-center">
		<div class="col-md-10 col-lg-5">
			<div>
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

						<button type="submit" class="btn btn-success" {{ $transaksi->selesai ? 'disabled' : '' }}>Konfirmasi</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('js')
<script type="text/javascript">
	window.invoicePrint = () => {
        let oldElement = $("body").html();
        let newElement = $("#invoice-print").html();

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
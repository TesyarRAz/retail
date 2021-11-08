@if(!$datas->isEmpty())
<div class="list-group">
	@foreach ($datas as $checkout)
	<a href="{{ route('customer.keranjang.show', $checkout->id) }}" class="list-group-item list-group-item-action mb-2">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				Invoice - <span class="fw-bold">{{ $checkout->invoice }}</span>
				<div class="mt-2">
					@if ($checkout->jenis == 'dikirim' && blank($checkout->ongkir))
					<span class="badge bg-danger">Ongkir belum diatur admin</span>
					@elseif (blank($checkout->bukti_transaksi))
					<span class="badge bg-danger">Belum Upload Bukti</span>
					@elseif(filled($checkout->keterangan_ditolak))
					<span class="badge bg-danger">Ditolak</span>
					@else
					<span class="badge bg-success">Menunggu Dikonfirmasi</span>	
					@endif
				</div>
			</div>
			<div class="text-start">
				<span class="text-muted d-block small">{{ $checkout->created_at->format('d-m-Y') }}</span>
			</div>
		</div>
	</a>
	@endforeach
</div>
@else
<span class="fw-bold">- Kosong -</span>
@endif
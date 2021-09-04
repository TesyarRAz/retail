@if(!$datas->isEmpty())
<div class="list-group">
	@foreach ($datas as $checkout)
	<a href="{{ route('customer.keranjang.show', $checkout->id) }}" class="list-group-item list-group-item-action">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				Invoice - <span class="fw-bold">{{ $checkout->invoice }}</span>
				<span class="text-muted d-block small">{{ $checkout->created_at->format('d-m-Y') }}</span>
			</div>
		</div>
	</a>
	@endforeach
</div>
@else
<span class="fw-bold">- Kosong -</span>
@endif
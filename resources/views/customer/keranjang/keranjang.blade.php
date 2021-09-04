@if(!$datas->isEmpty())
@foreach ($datas as $item)
<div class="card shadow">
	<div class="card-body">
		<div class="row">
			<div class="col-3">
				<img src="{{ $item->produk->image }}" class="img-fluid rounded">
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

<hr>
<span class="d-block">Total</span>
<span class="fw-bold">Rp. {{ number_format($datas->sum('price_total'), 0, ',', '.') }}</span>

<div class="d-flex justify-content-end mt-5 mb-5">
	<form action="{{ route('customer.keranjang.store') }}" method="post">
		@csrf

		<button type="submit" class="btn btn-success">
			Checkout
		</button>
	</form>
</div>
@else
<span class="fw-bold">- Kosong -</span>
@endif
@extends('layouts.customer')

@section('title', config('app.name') . ' - Keranjang')

@section('content')

<div class="container">
	<ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-keranjang" type="button" role="tab">
				Keranjang
			</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-checkout" type="button" role="tab">
				Checkout
			</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-selesai" type="button" role="tab">
				Selesai
			</button>
		</li>
	</ul>
	<div class="tab-content">
		{{-- Tab Keranjang --}}
		<div class="tab-pane fade show active" id="pills-keranjang" role="tabpanel">
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

			<hr>
			<span class="d-block">Total</span>
			<span class="fw-bold">Rp. {{ number_format($keranjangs->sum('price_total'), 0, ',', '.') }}</span>

			<div class="d-flex justify-content-end mt-5">
				<form action="{{ route('customer.keranjang.store') }}" method="post">
					@csrf
					
					<button type="submit" class="btn btn-success">
						Checkout
					</button>
				</form>
			</div>
		</div>

		{{-- Tab Checkout --}}
		<div class="tab-pane fade" id="pills-checkout" role="tabpanel">
			<div class="list-group">
				@foreach ($checkouts as $checkout)
  					<a href="{{ route('customer.keranjang.show', $checkout->id) }}" class="list-group-item list-group-item-action">
  						<div class="d-flex justify-content-between">
  							<div>
  								Invoice - {{ $checkout->invoice }}
  							</div>
  							<div>
  								{{ $checkout->created_at->format('d-m-Y') }}
  							</div>
  						</div>
  					</a>
				@endforeach
			</div>
		</div>

		{{-- Tab Selesai --}}
		<div class="tab-pane fade" id="pills-selesai" role="tabpanel">
			
		</div>
	</div>
</div>

@endsection
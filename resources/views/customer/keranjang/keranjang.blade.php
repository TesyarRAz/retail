@if(!$datas->isEmpty())
@foreach ($datas as $item)
<div class="card shadow mb-2">
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



<form class="my-5" action="{{ route('customer.keranjang.store') }}" method="post">
	@csrf

	<input type="hidden" name="type" value="pengambilan">
	
	<h4>Metode Pengambilan Barang</h4>
	<hr>
	<div class="form-check">
		<input class="form-check-input" type="radio" name="jenis" id="jenis_diambil" value="diambil" onchange="this.value && document.querySelector('#info_pengiriman').classList.add('d-none')" checked>
		<label class="form-check-label" for="jenis_diambil">
			Diambil
		</label>
	</div>
	<div class="form-check">
		<input class="form-check-input" type="radio" name="jenis" id="jenis_dikirim" value="dikirim" onchange="this.value && document.querySelector('#info_pengiriman').classList.remove('d-none')">
		<label class="form-check-label" for="jenis_dikirim">
			Dikirim
		</label>
	</div>
	<div class="my-2 d-none" id="info_pengiriman">
		<div class="mb-2">
			<input type="text" name="pengiriman_via" class="form-control" placeholder="Pengiriman (JNE, JNT, dll)">
		</div>
		<div class="mb-2">
			<textarea class="form-control" name="alamat_pengiriman" placeholder="Alamat"></textarea>
		</div>
	</div>
	<span class="text-danger small fw-bold">Ketika sudah disimpan, metode pengambilan tidak bisa dirubah lagi</span>

	<div class="d-flex justify-content-end mt-5 mb-5">
		<form action="{{ route('customer.keranjang.store') }}" method="post">
			@csrf

			<button type="submit" class="btn btn-success">
				Checkout
			</button>
		</form>
	</div>
</form>
@else
<span class="fw-bold">- Kosong -</span>
@endif
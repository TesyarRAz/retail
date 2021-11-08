@extends('adminlte::page')

@section('content_header')
<h4>Kelola Transaksi</h4>
@endsection

@section('content')

@include('admin.transaksi.tolak')

<div class="card">
	<div class="card-header">
		<span class="card-title">Daftar Transaksi</span>
	</div>
	<div class="card-body">
		<form id="form-filter-kategori" class="form-group">
			<nav class="nav nav-pills nav-justified mb-2" x-data="{ status: 'semua' }" x-init="$watch('status', () => $('#form-filter-kategori').trigger('change'))">
				<input type="hidden" name="status" x-model="status">
				<a class="nav-item nav-link" href="#" x-on:click="status = 'semua'" :class="status == 'semua' && 'active'">Semua</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'ongkir'" :class="status == 'ongkir' && 'active'">Ongkir</a>
				{{-- <a class="nav-item nav-link" href="#" x-on:click="status = 'bukti'" :class="status == 'bukti' && 'active'">Bukti</a> --}}
				<a class="nav-item nav-link" href="#" x-on:click="status = 'ditolak'" :class="status == 'ditolak' && 'active'">Ditolak</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'konfirmasi'" :class="status == 'konfirmasi' && 'active'">Konfirmasi</a>
				<a class="nav-item nav-link" href="#" x-on:click="status = 'selesai'" :class="status == 'selesai' && 'active'">Selesai</a>
			</nav>
			<div class="form-group">
				<label>Kategori</label>
				<select class="form-control" name="kategori_id">
					<option value="-1">Semua</option>
					@foreach($kategoris as $kategori)
					<option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Filter Tanggal</label>
				<div class="form-row no-gutters">
					<div class="col-lg-4">
						<input type="date" name="from" class="form-control form-control-sm" value="{{ now()->subDay(1)->format('Y-m-d') }}">
					</div>
					<div class="col-auto">
						-
					</div>
					<div class="col-lg-4">
						<input type="date" name="to" class="form-control form-control-sm" value="{{ now()->format('Y-m-d') }}">
					</div>
				</div>
			</div>
		</form>

		{!! $datatable->table() !!}
	</div>
</div>

@endsection

@push('js')
{!! $datatable->scripts() !!}

<script type="text/javascript" src="//unpkg.com/alpinejs@3.5.0/dist/cdn.min.js"></script>

<script type="text/javascript">
	$("#form-filter-kategori").on('change', function() {
		window?.LaravelDataTables?.dataTableBuilder?.ajax?.reload();
	});
</script>
@endpush
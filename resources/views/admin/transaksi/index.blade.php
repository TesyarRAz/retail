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
			<label>Kategori</label>
			<select class="form-control" name="kategori_id">
				@foreach($kategoris as $kategori)
				<option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
				@endforeach
			</select>
		</form>

		{!! $datatable->table() !!}
	</div>
</div>

@endsection

@push('js')
{!! $datatable->scripts() !!}
@endpush
@extends('adminlte::page')

@section('content_header')
<h4>Kelola Produk</h4>
@endsection

@section('content')

@include('admin.produk.create')
@include('admin.produk.edit')

<div class="card">
	<div class="card-header">
		<span class="card-title">Daftar Produk</span>
		<div class="card-tools">
			<button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modal-create">
				<i class="fas fa-fw fa-plus"></i>
				Tambah
			</button>
		</div>
	</div>
	<div class="card-body">
		{!! $datatable->table() !!}
	</div>
</div>

@endsection

@push('js')
{!! $datatable->scripts() !!}
@endpush
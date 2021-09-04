@extends('adminlte::page')

@section('content_header')
<h4>Kelola Kategori</h4>
@endsection

@section('content')

@include('admin.kategori.create')
@include('admin.kategori.edit')

<div class="card">
	<div class="card-header">
		<span class="card-title">Daftar Kategori</span>
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
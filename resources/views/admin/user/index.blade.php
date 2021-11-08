@extends('adminlte::page')

@section('content_header')
<h4>Kelola User</h4>
@endsection

@section('content')

@include('admin.transaksi.tolak')

<div class="card">
	<div class="card-header">
		<span class="card-title">Daftar User</span>
	</div>
	<div class="card-body">
		{!! $datatable->table() !!}
	</div>
</div>

@endsection

@push('js')
{!! $datatable->scripts() !!}
@endpush
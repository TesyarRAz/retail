@extends('adminlte::page')

@section('content_header')
<h4>Dashboard</h4>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{ $data->pesanan_baru }}</h3>

				<p>Pesanan Baru</p>
			</div>
			<div class="icon">
				<i class="fas fa-fw fa-shopping-bag"></i>
			</div>
			<a href="{{ route('admin.transaksi.index') }}" class="small-box-footer">Info lainnya <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-warning">
			<div class="inner">
				<h3>{{ $data->new_user }}</h3>

				<p>User Baru</p>
			</div>
			<div class="icon">
				<i class="fas fa-fw fa-user"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>
@endsection
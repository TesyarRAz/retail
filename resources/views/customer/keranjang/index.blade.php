@extends('layouts.customer')

@section('title', config('app.name') . ' - Keranjang')

@section('content')

<div class="container">
	<ul class="nav nav-pills mb-5">
		<li class="nav-item">
			<a href="{{ route('customer.keranjang.index', ['type' => 'keranjang']) }}" class="nav-link {{ request()->type == 'keranjang' ? 'active' : '' }}" type="button">
				Keranjang
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('customer.keranjang.index', ['type' => 'checkout']) }}" class="nav-link {{ request()->type == 'checkout' ? 'active' : '' }}" type="button">
				Checkout
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('customer.keranjang.index', ['type' => 'selesai']) }}" class="nav-link {{ request()->type == 'selesai' ? 'active' : '' }}" type="button">
				Selesai
			</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade show active">
			@if (request()->type == 'keranjang')
			@include('customer.keranjang.keranjang')
			@elseif (request()->type == 'checkout')
			@include('customer.keranjang.checkout')
			@elseif (request()->type == 'selesai')
			@include('customer.keranjang.selesai')
			@endif
		</div>
	</div>
</div>

@endsection
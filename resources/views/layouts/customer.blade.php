@extends('layouts.app')

@push('css')
<style type="text/css">
	.kategori-card {
		background-image: url({{ asset('assets/images/kategori-background.jpeg') }});
		width: 150px;
		height: 200px;
	}
</style>
@endpush

@push('before_content')

@include('partials.navbar')

@endpush
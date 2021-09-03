<script type="text/javascript">
	@if (session()->has('status'))
		Swal.fire("Informasi", '{!! session('status') !!}', 'info');
	@endif
	@if ($errors->any())
		Swal.fire("Error", '{!! $errors->first() !!}', 'error');
	@endif
</script>
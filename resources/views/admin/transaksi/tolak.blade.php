<form id="modal-tolak" class="modal fade" method="post" autocomplete="off">
	@csrf
	@method('put')

	<input type="hidden" name="type" value="tolak">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Alasan Penolakan</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span>x</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Alasan <span class="text-danger">*</span></label>
					<textarea class="form-control" name="keterangan_ditolak" required></textarea>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
			</div>
		</div>
	</div>
</form>

@push('js')
<script type="text/javascript">
	window.tolak = (id) => {
		$("#modal-tolak").attr('action', `{{ url('admin/transaksi') }}/${id}`);
		$("#modal-tolak").modal();
	}
</script>
@endpush
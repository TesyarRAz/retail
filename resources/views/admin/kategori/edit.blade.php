<form id="modal-edit" class="modal fade" method="post" autocomplete="off">
	@csrf
	@method('put')

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Kategori</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span>x</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Nama <span class="font-weight-bold text-danger">*</span></label>
					<input type="text" name="name" class="form-control" required>
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
	$(function() {
		let modal = $("#modal-edit");

		window.edit = (id) => {
			let url_target = `{{ url('admin/kategori') }}/${id}`;
			$.getJSON(url_target, function(data) {
				modal.find("input,textarea").val(function(index, value) {
					return ['_method', '_token'].includes(this.name) ? value : (data[this.name]);
				}).trigger("input");

				modal.attr('action', url_target);
				modal.modal();
			});
		}
	});
</script>
@endpush
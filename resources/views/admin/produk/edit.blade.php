<form id="modal-edit" class="modal fade" method="post" autocomplete="off" enctype="multipart/form-data">
	@csrf
	@method('put')

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Produk</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span>x</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Nama <span class="font-weight-bold text-danger">*</span></label>
					<input type="text" name="name" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Harga <span class="font-weight-bold text-danger">*</span></label>
					<input type="text" name="price" class="form-control" data-mask="000.000.000.000" data-mask-reverse="true" required>
				</div>
				<div class="form-group">
					<label>Kategori <span class="font-weight-bold text-danger">*</span></label>
					<select class="form-control" name="kategori_id">
						@foreach ($kategoris as $kategori)
						<option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group" data-toggle="image-preview">
					<label>Gambar <span class="text-danger">*</span></label>
					<input type="file" name="image" class="d-none" data-source="true" accept="image/*">
					<img src="{{ asset('assets/images/empty-image.png') }}" role="button" class="d-block img-thumbnail" width="300" height="300" data-target="true">
				</div>
				<div class="form-group">
					<label>Deskripsi</label>
					<textarea class="form-control" name="description" required></textarea>
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
			modal.find("input[name=image]").attr('src', '{{ asset('assets/images/empty-image.png') }}');

			let url_target = `{{ url('admin/produk') }}/${id}`;
			$.getJSON(url_target, function(data) {
				modal.find("input,textarea,select").val(function(index, value) {
					return ['_method', '_token', 'image'].includes(this.name) ? value : (data[this.name]);
				}).trigger("input");

				modal.find("input[name=image]").siblings('img[data-target]').attr('src', data.image);

				modal.attr('action', url_target);
				modal.modal();
			});
		}
	});
</script>
@endpush
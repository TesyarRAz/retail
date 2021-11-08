<form id="modal-create" class="modal fade" action="{{ route('admin.kategori.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
	@csrf

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Kategori</h4>
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
			<div class="form-group" data-toggle="image-preview">
				<label>Gambar <span class="text-danger">*</span></label>
				<input type="file" name="gambar" class="d-none" data-source="true" accept="image/*">
				<img src="{{ asset('assets/images/empty-image.png') }}" role="button" class="d-block img-thumbnail" width="300" height="300" data-target="true">
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
			</div>
		</div>
	</div>
</form>
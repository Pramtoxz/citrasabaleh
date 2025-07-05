<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4 animate__animated animate__fadeIn">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary"><?= $pageTitle ?></h6>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form id="formEditKamar" method="post" action="<?= site_url('kamar/update/' . $kamar['idkamar']) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kamar <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" 
                            id="nama" name="nama" value="<?= old('nama', $kamar['nama']) ?>" required>
                        <div class="invalid-feedback">
                            <?= session('errors.nama') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control <?= session('errors.harga') ? 'is-invalid' : '' ?>" 
                                        id="harga" name="harga" value="<?= old('harga', $kamar['harga']) ?>" min="0" required>
                                    <div class="invalid-feedback">
                                        <?= session('errors.harga') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kapasitas" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control <?= session('errors.kapasitas') ? 'is-invalid' : '' ?>" 
                                        id="kapasitas" name="kapasitas" value="<?= old('kapasitas', $kamar['kapasitas']) ?>" min="1" required>
                                    <span class="input-group-text">orang</span>
                                    <div class="invalid-feedback">
                                        <?= session('errors.kapasitas') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control <?= session('errors.deskripsi') ? 'is-invalid' : '' ?>" 
                            id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi', $kamar['deskripsi']) ?></textarea>
                        <div class="invalid-feedback">
                            <?= session('errors.deskripsi') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_kamar" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select <?= session('errors.status_kamar') ? 'is-invalid' : '' ?>" 
                            id="status_kamar" name="status_kamar" required>
                            <option value="" disabled>Pilih Status</option>
                            <option value="1" <?= (old('status_kamar', $kamar['status_kamar']) == '1') ? 'selected' : '' ?>>Tersedia</option>
                            <option value="2" <?= (old('status_kamar', $kamar['status_kamar']) == '2') ? 'selected' : '' ?>>Tidak Tersedia</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.status_kamar') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Kamar</label>
                        <input type="file" class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>" 
                            id="gambar" name="gambar" accept="image/*">
                        <div class="invalid-feedback">
                            <?= session('errors.gambar') ?>
                        </div>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Ukuran maksimal: 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                        <div class="mt-2">
                            <?php if (!empty($kamar['gambar'])) : ?>
                                <p>Gambar saat ini:</p>
                                <img src="<?= base_url('writable/uploads/kamar/' . $kamar['gambar']) ?>" 
                                    alt="Gambar <?= $kamar['nama'] ?>" class="preview-image">
                            <?php endif; ?>
                            <img id="preview" src="" alt="Preview Gambar Baru" class="preview-image d-none">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="<?= site_url('kamar') ?>" class="btn btn-secondary me-md-2">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnUpdate">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Preview gambar
    $('#gambar').on('change', function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#preview').attr('src', event.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // Submit form dengan AJAX
    $('#formEditKamar').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            beforeSend: function() {
                $('#btnUpdate').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memperbarui...').prop('disabled', true);
            },
            complete: function() {
                $('#btnUpdate').html('Perbarui').prop('disabled', false);
            },
            success: function(response) {
                if (response.status) {
                    // Tampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    }).then((result) => {
                        window.location.href = response.redirect;
                    });
                } else {
                    // Handle validasi error
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).siblings('.invalid-feedback').text(value);
                        });
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Silakan periksa kembali input Anda',
                        });
                    } else {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat memperbarui data',
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                // Tampilkan pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal mengirim permintaan ke server',
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?> 
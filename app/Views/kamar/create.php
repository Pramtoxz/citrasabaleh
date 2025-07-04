<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('styles') ?>
<style>
    .preview-image {
        max-width: 200px;
        margin-top: 10px;
        border-radius: 5px;
    }
    .form-label {
        font-weight: 500;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4 animate__animated animate__fadeIn">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary"><?= $pageTitle ?></h6>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form id="formKamar" method="post" action="<?= site_url('kamar/create') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kamar <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" 
                            id="nama" name="nama" value="<?= old('nama') ?>" required>
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
                                        id="harga" name="harga" value="<?= old('harga') ?>" min="0" required>
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
                                        id="kapasitas" name="kapasitas" value="<?= old('kapasitas') ?>" min="1" required>
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
                            id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi') ?></textarea>
                        <div class="invalid-feedback">
                            <?= session('errors.deskripsi') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_kamar" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select <?= session('errors.status_kamar') ? 'is-invalid' : '' ?>" 
                            id="status_kamar" name="status_kamar" required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="1" <?= old('status_kamar') == '1' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="2" <?= old('status_kamar') == '2' ? 'selected' : '' ?>>Tidak Tersedia</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.status_kamar') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Kamar <span class="text-danger">*</span></label>
                        <input type="file" class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>" 
                            id="gambar" name="gambar" accept="image/*" required>
                        <div class="invalid-feedback">
                            <?= session('errors.gambar') ?>
                        </div>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Ukuran maksimal: 2MB.</small>
                        <div class="mt-2">
                            <img id="preview" src="" alt="Preview Gambar" class="preview-image d-none">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="<?= site_url('kamar') ?>" class="btn btn-secondary me-md-2">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
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
    $('#formKamar').on('submit', function(e) {
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
                $('#btnSimpan').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...').prop('disabled', true);
            },
            complete: function() {
                $('#btnSimpan').html('Simpan').prop('disabled', false);
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
                    // Tampilkan pesan error
                    if (response.errors) {
                        // Reset semua error
                        $('.is-invalid').removeClass('is-invalid');
                        
                        // Tampilkan error validasi
                        $.each(response.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            if ($('#error-' + key).length) {
                                $('#error-' + key).html(value);
                            } else {
                                $('#' + key).after(`<div class="invalid-feedback" id="error-${key}">${value}</div>`);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data',
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menyimpan data kamar. Silakan coba lagi.',
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?> 
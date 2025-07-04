<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('styles') ?>
<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4 animate__animated animate__fadeIn">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Tamu</h6>
        <a href="<?= site_url('tamu') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <form id="formEditTamu" method="post" action="<?= site_url('tamu/update/' . $tamu['nik']) ?>">
            <?= csrf_field() ?>
            
            <div class="mb-3 row">
                <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nik" name="nik" value="<?= $tamu['nik'] ?>" disabled>
                    <small class="text-muted">NIK tidak dapat diubah</small>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $tamu['nama'] ?>" required placeholder="Masukkan nama lengkap">
                    <div class="invalid-feedback" id="error-nama"></div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="jenkel" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenkel" id="jenkel-l" value="L" <?= $tamu['jenkel'] == 'L' ? 'checked' : '' ?> required>
                        <label class="form-check-label" for="jenkel-l">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenkel" id="jenkel-p" value="P" <?= $tamu['jenkel'] == 'P' ? 'checked' : '' ?> required>
                        <label class="form-check-label" for="jenkel-p">Perempuan</label>
                    </div>
                    <div class="invalid-feedback" id="error-jenkel"></div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="tgllahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control datepicker" id="tgllahir" name="tgllahir" value="<?= $tamu['tgllahir'] ?>" required placeholder="Pilih tanggal lahir" autocomplete="off">
                    <div class="invalid-feedback" id="error-tgllahir"></div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required><?= $tamu['alamat'] ?></textarea>
                    <div class="invalid-feedback" id="error-alamat"></div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="nohp" class="col-sm-3 col-form-label">Nomor HP</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nohp" name="nohp" value="<?= $tamu['nohp'] ?>" required placeholder="Masukkan nomor HP">
                    <div class="invalid-feedback" id="error-nohp"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                    <a href="<?= site_url('tamu') ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
$(document).ready(function() {
    // Initialize Flatpickr date picker
    $(".datepicker").flatpickr({
        locale: "id",
        dateFormat: "Y-m-d",
        maxDate: "today",
        allowInput: true
    });

    // Form validation and submission
    $("#formEditTamu").on('submit', function(e) {
        e.preventDefault();
        
        // Reset validation
        $(this).find('.is-invalid').removeClass('is-invalid');
        
        // Submit form with AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Redirect to index page
                        window.location.href = response.redirect;
                    });
                } else {
                    // Show validation errors
                    if (response.errors) {
                        $.each(response.errors, function(field, message) {
                            $('#' + field).addClass('is-invalid');
                            $('#error-' + field).text(message);
                        });
                    } else {
                        // Show general error
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan saat menyimpan data',
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengirim data',
                });
            }
        });
    });
    
    // Validasi nomor HP
    $('#nohp').on('input', function() {
        this.value = this.value.replace(/[^0-9+\-]/g, '');
    });
});
</script>
<?= $this->endSection() ?>

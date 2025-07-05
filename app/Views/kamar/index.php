<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4 animate__animated animate__fadeIn">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kamar</h6>
        <a href="<?= site_url('kamar/new') ?>" class="btn btn-primary btn-sm" id="btnTambah">
            <i class="fas fa-plus-circle me-1"></i> Tambah Kamar
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="kamar-datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" data-ajax-url="<?= site_url('kamar/datatable') ?>">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Kamar</th>
                        <th>Harga</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Kamar -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 text-center mb-3">
                        <img id="detail-gambar" src="" alt="Gambar Kamar" class="img-preview">
                    </div>
                    <div class="col-md-7">
                        <h4 id="detail-nama" class="mb-3"></h4>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width: 130px;"><strong>ID Kamar</strong></td>
                                    <td id="detail-idkamar"></td>
                                </tr>
                                <tr>
                                    <td><strong>Harga</strong></td>
                                    <td id="detail-harga"></td>
                                </tr>
                                <tr>
                                    <td><strong>Kapasitas</strong></td>
                                    <td id="detail-kapasitas"></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td id="detail-status"></td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat</strong></td>
                                    <td id="detail-created"></td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate</strong></td>
                                    <td id="detail-updated"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Deskripsi</h6>
                            </div>
                            <div class="card-body" id="detail-deskripsi">
                                <!-- Deskripsi kamar akan ditampilkan di sini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a id="btn-edit-modal" href="#" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>


<script>
$(document).ready(function() {
    // Initialize DataTables
    var kamarTable = $('#kamar-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('kamar/datatable') ?>',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [0, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });

    // Tambah data
    $('#btnTambah').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });

    // Lihat detail
    $('#kamar-datatable').on('click', '.btn-view', function() {
        var id = $(this).data('id');
        
        // AJAX request
        $.ajax({
            url: "<?= site_url('kamar/show/') ?>" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if(response.status) {
                    var data = response.data;
                    
                    // Set URL untuk tombol edit
                    $('#btn-edit-modal').attr('href', "<?= site_url('kamar/edit/') ?>" + data.idkamar);
                    
                    // Isi data ke modal
                    $('#detail-nama').text(data.nama);
                    $('#detail-idkamar').text(data.idkamar);
                    $('#detail-harga').text(data.harga_formatted);
                    $('#detail-kapasitas').text(data.kapasitas + ' orang');
                    $('#detail-status').html(data.status_text == 'Tersedia' ? 
                        '<span class="badge bg-success">Tersedia</span>' : 
                        '<span class="badge bg-danger">Tidak Tersedia</span>');
                    $('#detail-created').text(data.created_at_formatted);
                    $('#detail-updated').text(data.updated_at_formatted);
                    $('#detail-deskripsi').html(data.deskripsi);
                    $('#detail-gambar').attr('src', data.gambar_url);
                    $('#detail-gambar').attr('alt', 'Gambar ' + data.nama);
                    
                    // Tampilkan modal
                    var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                    detailModal.show();
                } else {
                    // Tampilkan pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Tampilkan pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal mengambil data kamar',
                });
            }
        });
    });

    // Edit data
    $('#kamar-datatable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        window.location.href = "<?= site_url('kamar/edit/') ?>" + id;
    });
    
    // Hapus data
    $('#kamar-datatable').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Anda yakin?',
            html: `Ingin menghapus kamar <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX request untuk hapus data
                $.ajax({
                    url: "<?= site_url('kamar/delete/') ?>" + id,
                    type: "DELETE",
                    dataType: "json",
                    success: function(response) {
                        if(response.status) {
                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            });
                            
                            // Refresh datatable
                            kamarTable.ajax.reload();
                        } else {
                            // Tampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menghapus data kamar',
                        });
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?> 
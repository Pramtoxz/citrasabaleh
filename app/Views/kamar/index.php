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
    
    // Tambah data dengan AJAX
    $('#btnTambah').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
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
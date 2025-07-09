<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('styles') ?>


<!-- Custom Style for SweetAlert2 -->

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4 animate__animated animate__fadeIn">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tamu</h6>
        <a href="<?= site_url('tamu/new') ?>" class="btn btn-primary btn-sm" id="btnTambah">
            <i class="fas fa-plus-circle me-1"></i> Tambah Data
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tamu-datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" data-ajax-url="<?= site_url('tamu/datatable') ?>">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>No.HP</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded by DataTables -->
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
    var tamuTable = $('#tamu-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('tamu/datatable') ?>',
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
        drawCallback: function() {
            // Reinitialize event handlers setelah reload
            reinitializeEvents();
        }
    });

    // Tambah data dengan AJAX
    $('#btnTambah').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
});
</script>
<?= $this->endSection() ?>

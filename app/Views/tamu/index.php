<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('styles') ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

<!-- Custom Style for SweetAlert2 -->
<style>
    .swal2-popup {
        font-size: 1rem;
    }
    .swal2-modal .form-control {
        margin-bottom: 10px;
    }
    .swal2-modal .form-label {
        display: block;
        text-align: left;
        font-weight: 500;
        margin-bottom: 5px;
    }
    .swal2-modal .invalid-feedback {
        display: block;
        width: 100%;
        text-align: left;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: -8px;
        margin-bottom: 8px;
    }
    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }
    .detail-table td {
        padding: 6px 4px;
        vertical-align: top;
        text-align: left;
    }
    .detail-table .label {
        width: 35%;
        font-weight: 500;
    }
    .detail-table .separator {
        width: 5%;
    }
    .detail-table .value {
        width: 60%;
    }
    .user-account-info {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #dee2e6;
    }
    .no-account-text {
        color: #dc3545;
        font-style: italic;
    }
</style>
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
            <table id="tamu-datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No.HP</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Tanggal Daftar</th>
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
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables
    var tamuTable = $('#tamu-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= site_url('tamu/datatable') ?>",
        columns: [
            { data: 'no', orderable: false },
            { data: 'nik' },
            { data: 'nama' },
            { data: 'alamat' },
            { data: 'nohp' },
            { data: 'jenkel' },
            { data: 'tgllahir' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(difilter dari total _MAX_ data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        },
        responsive: true
    });

    // Tambah data dengan AJAX
    $('#btnTambah').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });

    // Tampilkan detail
    $('#tamu-datatable').on('click', '.btn-detail', function() {
        var id = $(this).data('id');
        
        // AJAX request untuk mengambil data
        $.ajax({
            url: "<?= site_url('tamu/show/') ?>" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if(response.status) {
                    const data = response.data;
                    
                    // Buat konten HTML untuk detail
                    let userAccountInfo = '';
                    if (data.has_account) {
                        userAccountInfo = `
                            <div class="user-account-info">
                                <h6 class="mb-2">Informasi Akun</h6>
                                <table class="detail-table">
                                    <tr>
                                        <td class="label">Username</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.username || '-'}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Email</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.email || '-'}</td>
                                    </tr>
                                </table>
                            </div>`;
                    } else {
                        userAccountInfo = `
                            <div class="user-account-info">
                                <p class="no-account-text">Tamu belum memiliki akun user</p>
                            </div>`;
                    }
                    
                    // Tampilkan detail dengan SweetAlert2
                    Swal.fire({
                        title: 'Detail Tamu: ' + data.nama,
                        html: `
                            <div class="text-start">
                                <table class="detail-table">
                                    <tr>
                                        <td class="label">NIK</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.nik}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Nama</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.nama}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Alamat</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.alamat}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">No.HP</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.nohp}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Jenis Kelamin</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.jenkel}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Tanggal Lahir</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.tgllahir}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Tanggal Daftar</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.created_at}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Terakhir Diperbarui</td>
                                        <td class="separator">:</td>
                                        <td class="value">${data.updated_at}</td>
                                    </tr>
                                </table>
                                ${userAccountInfo}
                            </div>
                        `,
                        confirmButtonText: 'Tutup',
                        width: '600px'
                    });
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
                    text: 'Gagal mengambil data tamu',
                });
            }
        });
    });

    // Edit data
    $('#tamu-datatable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        window.location.href = "<?= site_url('tamu/edit/') ?>" + id;
    });

    // Hapus data
    $('#tamu-datatable').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Anda yakin?',
            html: `Ingin menghapus data tamu <strong>${nama}</strong>?`,
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
                    url: "<?= site_url('tamu/delete/') ?>" + id,
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
                            tamuTable.ajax.reload();
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
                            text: 'Gagal menghapus data tamu',
                        });
                    }
                });
            }
        });
    });

    // Buat Akun User
    $('#tamu-datatable').on('click', '.btn-create-user', function() {
        var nik = $(this).data('nik');
        var nama = $(this).data('nama');

        // Buat form dengan Sweetalert2
        Swal.fire({
            title: 'Buat Akun User untuk ' + nama,
            html: `
                <form id="formBuatAkunSwal">
                    <input type="hidden" id="swal-nik_tamu" value="${nik}">
                    <div class="mb-3 text-start">
                        <label for="swal-username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="swal-username" required>
                        <div class="invalid-feedback" id="swal-error-username"></div>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="swal-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="swal-email" required>
                        <div class="invalid-feedback" id="swal-error-email"></div>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="swal-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="swal-password" required>
                        <div class="invalid-feedback" id="swal-error-password"></div>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="swal-confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="swal-confirm_password" required>
                        <div class="invalid-feedback" id="swal-error-confirm_password"></div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            focusConfirm: false,
            allowOutsideClick: false,
            didOpen: () => {
                // Focus pada input pertama
                document.getElementById('swal-username').focus();
            },
            preConfirm: () => {
                // Validasi input
                const username = document.getElementById('swal-username').value;
                const email = document.getElementById('swal-email').value;
                const password = document.getElementById('swal-password').value;
                const confirm_password = document.getElementById('swal-confirm_password').value;
                
                let isValid = true;
                
                // Reset validasi sebelumnya
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                
                // Validasi username
                if (!username) {
                    document.getElementById('swal-username').classList.add('is-invalid');
                    document.getElementById('swal-error-username').textContent = 'Username harus diisi';
                    isValid = false;
                }
                
                // Validasi email
                if (!email) {
                    document.getElementById('swal-email').classList.add('is-invalid');
                    document.getElementById('swal-error-email').textContent = 'Email harus diisi';
                    isValid = false;
                }
                
                // Validasi password
                if (!password) {
                    document.getElementById('swal-password').classList.add('is-invalid');
                    document.getElementById('swal-error-password').textContent = 'Password harus diisi';
                    isValid = false;
                }
                
                // Validasi konfirmasi password
                if (password !== confirm_password) {
                    document.getElementById('swal-confirm_password').classList.add('is-invalid');
                    document.getElementById('swal-error-confirm_password').textContent = 'Konfirmasi password tidak cocok';
                    isValid = false;
                }
                
                if (!isValid) {
                    return false;
                }
                
                // Return data untuk diproses
                return {
                    nik_tamu: document.getElementById('swal-nik_tamu').value,
                    username: username,
                    email: email,
                    password: password,
                    confirm_password: confirm_password
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika form valid, kirim data ke server
                $.ajax({
                    url: "<?= site_url('tamu/create-user') ?>",
                    type: "POST",
                    data: result.value,
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
                            tamuTable.ajax.reload();
                        } else {
                            // Tampilkan pesan error
                            let errorMessage = response.message;
                            
                            if (response.errors) {
                                errorMessage = Object.values(response.errors).join('<br>');
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                html: errorMessage,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal membuat akun user',
                        });
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>

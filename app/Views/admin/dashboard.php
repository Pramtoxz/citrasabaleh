<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<!-- Dashboard Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">1,250</h3>
                    <p class="text-muted mb-0">Total Pengguna</p>
                </div>
                <div class="ms-auto">
                    <div class="badge bg-success">
                        <i class="fas fa-arrow-up"></i> 12.5%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                    <i class="fas fa-shopping-cart fa-2x text-success"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">720</h3>
                    <p class="text-muted mb-0">Total Pesanan</p>
                </div>
                <div class="ms-auto">
                    <div class="badge bg-success">
                        <i class="fas fa-arrow-up"></i> 8.4%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                    <i class="fas fa-box-open fa-2x text-warning"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">485</h3>
                    <p class="text-muted mb-0">Total Produk</p>
                </div>
                <div class="ms-auto">
                    <div class="badge bg-danger">
                        <i class="fas fa-arrow-down"></i> 3.2%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.6s">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                    <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">Rp 8.5 Jt</h3>
                    <p class="text-muted mb-0">Pendapatan</p>
                </div>
                <div class="ms-auto">
                    <div class="badge bg-success">
                        <i class="fas fa-arrow-up"></i> 15.7%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.8s">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Penjualan Bulanan</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartOptionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Tahun 2023
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="chartOptionDropdown">
                        <li><a class="dropdown-item" href="#">Tahun 2023</a></li>
                        <li><a class="dropdown-item" href="#">Tahun 2022</a></li>
                        <li><a class="dropdown-item" href="#">Tahun 2021</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 1s">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">Distribusi Kategori</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="260"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp" style="animation-delay: 1.2s">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pesanan Terbaru</h5>
                <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-2023-001</td>
                                <td>Ahmad Fadillah</td>
                                <td>Smartphone XYZ</td>
                                <td>25 Juli 2023</td>
                                <td>Rp 5.250.000</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-outline-success"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-2023-002</td>
                                <td>Siti Nurhaliza</td>
                                <td>Laptop ABC</td>
                                <td>24 Juli 2023</td>
                                <td>Rp 8.750.000</td>
                                <td><span class="badge bg-warning text-dark">Dikirim</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-outline-success"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-2023-003</td>
                                <td>Budi Santoso</td>
                                <td>Headphone Pro</td>
                                <td>23 Juli 2023</td>
                                <td>Rp 1.200.000</td>
                                <td><span class="badge bg-primary">Diproses</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-outline-success"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-2023-004</td>
                                <td>Dewi Lestari</td>
                                <td>Smart Watch</td>
                                <td>22 Juli 2023</td>
                                <td>Rp 2.450.000</td>
                                <td><span class="badge bg-danger">Dibatalkan</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-outline-success"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-2023-005</td>
                                <td>Eko Prasetyo</td>
                                <td>Camera DSLR</td>
                                <td>21 Juli 2023</td>
                                <td>Rp 7.500.000</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-outline-success"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    var salesCtx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Penjualan',
                data: [12, 19, 15, 17, 22, 30, 35, 28, 25, 30, 40, 45],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'white',
                pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' Jt';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Category Chart
    var categoryCtx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Elektronik', 'Fashion', 'Alat Rumah Tangga', 'Kesehatan', 'Lainnya'],
            datasets: [{
                data: [35, 25, 20, 15, 5],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        boxWidth: 10
                    }
                }
            },
            cutout: '70%',
            animation: {
                animateScale: true
            }
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?> 
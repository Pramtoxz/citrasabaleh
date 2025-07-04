<div class="sidebar-wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3 class="mb-0">Admin Panel</h3>
            <p class="text-muted mb-0">Management System</p>
        </div>

        <ul class="list-unstyled components">
            <li class="active">
                <a href="#" class="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-building"></i>
                    <span>Master</span>
                </a>
                <ul class="collapse list-unstyled animate__animated animate__fadeIn" id="userSubmenu">
                    <li>
                        <a href="<?= site_url('tamu') ?>"><i class="fas fa-user me-2"></i>Tamu</a>
                    </li>
                    <li>
                        <a href="<?= site_url('kamar') ?>"><i class="fas fa-bed me-2"></i>Kamar</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#productSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-cash-register"></i>
                    <span>Transaction</span>
                </a>
                <ul class="collapse list-unstyled animate__animated animate__fadeIn" id="productSubmenu">
                    <li>
                        <a href="#"><i class="fas fa-building-circle-check me-2"></i>Check In</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-building-circle-check me-2"></i>Check Out</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-chart-line"></i>
                    <span>Report</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Setting</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="text-center">
                <div class="text-white small">
                    <span>&copy; 2025 Wisma Citra Sabaleh</span>
                </div>
            </div>
        </div>
    </nav>
</div> 
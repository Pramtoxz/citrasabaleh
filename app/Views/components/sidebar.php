<div class="sidebar-wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3 class="mb-0">Admin Panel</h3>
            <p class="text-muted mb-0">Management System</p>
        </div>

        <ul class="list-unstyled components">
            <li class="<?= current_url() == site_url('admin') ? 'active' : '' ?>">
                <a href="<?= site_url('admin') ?>" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= strpos(current_url(), 'tamu') !== false || strpos(current_url(), 'kamar') !== false ? 'active' : '' ?>">
                <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="<?= strpos(current_url(), 'tamu') !== false || strpos(current_url(), 'kamar') !== false ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fas fa-building"></i>
                    <span>Master</span>
                </a>
                <ul class="collapse list-unstyled animate__animated animate__fadeIn <?= strpos(current_url(), 'tamu') !== false || strpos(current_url(), 'kamar') !== false ? 'show' : '' ?>" id="userSubmenu">
                    <li class="<?= strpos(current_url(), 'tamu') !== false ? 'active' : '' ?>">
                        <a href="<?= site_url('tamu') ?>" class="nav-link">
                            <i class="fas fa-user me-2"></i>
                            <span>Tamu</span>
                        </a>
                    </li>
                    <li class="<?= strpos(current_url(), 'kamar') !== false ? 'active' : '' ?>">
                        <a href="<?= site_url('kamar') ?>" class="nav-link">
                            <i class="fas fa-bed me-2"></i>
                            <span>Kamar</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?= strpos(current_url(), 'checkin') !== false || strpos(current_url(), 'checkout') !== false ? 'active' : '' ?>">
                <a href="#productSubmenu" data-bs-toggle="collapse" aria-expanded="<?= strpos(current_url(), 'checkin') !== false || strpos(current_url(), 'checkout') !== false ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fas fa-cash-register"></i>
                    <span>Transaction</span>
                </a>
                <ul class="collapse list-unstyled animate__animated animate__fadeIn <?= strpos(current_url(), 'checkin') !== false || strpos(current_url(), 'checkout') !== false ? 'show' : '' ?>" id="productSubmenu">
                    <li class="<?= strpos(current_url(), 'checkin') !== false ? 'active' : '' ?>">
                        <a href="<?= site_url('checkin') ?>" class="nav-link">
                            <i class="fas fa-building-circle-check me-2"></i>
                            <span>Check In</span>
                        </a>
                    </li>
                    <li class="<?= strpos(current_url(), 'checkout') !== false ? 'active' : '' ?>">
                        <a href="<?= site_url('checkout') ?>" class="nav-link">
                            <i class="fas fa-building-circle-check me-2"></i>
                            <span>Check Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?= strpos(current_url(), 'report') !== false ? 'active' : '' ?>">
                <a href="<?= site_url('report') ?>" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Report</span>
                </a>
            </li>
            <li class="<?= strpos(current_url(), 'setting') !== false ? 'active' : '' ?>">
                <a href="<?= site_url('setting') ?>" class="nav-link">
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
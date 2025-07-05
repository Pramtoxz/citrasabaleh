<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button type="button" id="navbarToggleSidebar" class="btn btn-outline-light me-2">
            <i class="fas fa-bars"></i>
        </button>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('navbarToggleSidebar');
                const sidebar = document.getElementById('sidebar');
                const content = document.getElementById('content');
                const body = document.body;
                
                if (toggleBtn && sidebar && content) {
                    // Toggle sidebar saat tombol diklik
                    toggleBtn.addEventListener('click', function() {
                        // Toggle sidebar
                        sidebar.classList.toggle('active');
                        content.classList.toggle('active');
                        
                        // Toggle overlay pada mobile
                        if (window.innerWidth <= 767) {
                            body.classList.toggle('sidebar-active');
                        }
                    });
                    
                    // Close sidebar when clicking outside
                    document.addEventListener('click', function(e) {
                        // Hanya lakukan di mobile dan jika sidebar terbuka
                        if (window.innerWidth <= 767 && body.classList.contains('sidebar-active')) {
                            // Jika klik di luar sidebar dan bukan tombol toggle
                            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                                sidebar.classList.remove('active');
                                content.classList.remove('active');
                                body.classList.remove('sidebar-active');
                            }
                        }
                    });
                }
            });
        </script>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Notifikasi 1</a></li>
                        <li><a class="dropdown-item" href="#">Notifikasi 2</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Lihat semua notifikasi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="User" class="rounded-circle" width="32" height="32">
                        <span class="ms-2">Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" id="logout"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav> 
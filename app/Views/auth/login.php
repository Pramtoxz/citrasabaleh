<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wisma Citra Sabaleh</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B5A2B;
            --secondary-color: #D4AF37;
            --accent-color: #F5F5DC;
            --dark-color: #3C2A1E;
            --light-color: #FFF8E7;
            --text-color: #333333;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--light-color) 0%, #FFFFFF 100%);
            min-height: 100vh;
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        .brand-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }
        
        .brand-subtitle {
            color: var(--secondary-color);
            font-size: 1rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }
        
        .login-container {
            display: flex;
            min-height: 100vh;
        }
        
        .login-image {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1080&q=80') center/cover no-repeat;
            position: relative;
            box-shadow: 0 0 30px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.4);
        }
        
        .image-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            padding: 2rem;
            max-width: 80%;
        }
        
        .image-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .image-content p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        .login-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-form-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .login-form-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            border-radius: 50%;
            padding: 5px;
            border: 2px solid var(--secondary-color);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding-left: 45px;
            font-size: 0.95rem;
            transition: all var(--transition-speed);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(139, 90, 43, 0.25);
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all var(--transition-speed);
        }
        
        .btn-primary:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-outline-secondary {
            color: var(--primary-color);
            border-color: #ddd;
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
            border-color: var(--accent-color);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-text, .form-check-label {
            font-size: 0.9rem;
        }
        
        .auth-links {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
        }
        
        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-speed);
        }
        
        .auth-links a:hover {
            color: var(--secondary-color);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.85rem;
            color: #777;
        }
        
        .decoration-element {
            position: absolute;
            z-index: -1;
            opacity: 0.5;
        }
        
        .decoration-1 {
            top: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--secondary-color) 0%, transparent 70%);
        }
        
        .decoration-2 {
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-color) 0%, transparent 70%);
        }
        
        /* Animation classes */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .login-image {
                display: none;
            }
            
            .login-form-container {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .login-form-wrapper {
                padding: 2rem 1.5rem;
            }
            
            .brand-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side: Image with Overlay Text -->
        <div class="login-image d-none d-lg-flex" data-aos="fade-right" data-aos-duration="1000">
            <div class="image-content">
                <h2>Selamat Datang di Wisma Citra Sabaleh</h2>
                <p>Nikmati pengalaman menginap yang nyaman dan mewah dengan pelayanan terbaik kami.</p>
                <div class="d-flex justify-content-center">
                    <div class="me-3">
                        <i class="fas fa-star fa-2x mb-2 text-warning"></i>
                        <h5>Fasilitas Lengkap</h5>
                    </div>
                    <div class="me-3">
                        <i class="fas fa-map-marker-alt fa-2x mb-2 text-warning"></i>
                        <h5>Lokasi Strategis</h5>
                    </div>
                    <div>
                        <i class="fas fa-concierge-bell fa-2x mb-2 text-warning"></i>
                        <h5>Pelayanan Prima</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Login Form -->
        <div class="login-form-container">
            <div class="login-form-wrapper" data-aos="fade-up" data-aos-duration="800">
                <div class="decoration-element decoration-1"></div>
                <div class="decoration-element decoration-2"></div>
                
                <div class="login-logo">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Wisma Citra Sabaleh" onerror="this.src='https://via.placeholder.com/120x120?text=WISMA'">
                </div>
                
                <h1 class="brand-title text-center">Wisma Citra Sabaleh</h1>
                <p class="brand-subtitle text-center">Kenyamanan Adalah Prioritas</p>
                
                <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <form id="loginForm" class="fade-in-up" style="animation-delay: 0.3s;">
                    <div class="form-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username atau Email" required>
                    </div>
                    
                    <div class="form-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password position-absolute end-0 top-0 mt-2 me-2" style="height: 46px; width: 46px; border-radius: 8px;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <div class="row mb-4 align-items-center">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <a href="<?= site_url('auth/forgot-password') ?>" class="text-decoration-none">Lupa Password?</a>
                        </div>
                    </div>
                    
                    <div class="d-grid fade-in-up" style="animation-delay: 0.5s;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk
                        </button>
                    </div>
                </form>
                
                <div class="auth-links fade-in-up" style="animation-delay: 0.7s;">
                    Belum punya akun? <a href="<?= site_url('auth/register') ?>">Daftar Sekarang</a>
                </div>
                
                <div class="login-footer fade-in-up" style="animation-delay: 0.9s;">
                    &copy; <?= date('Y') ?> Wisma Citra Sabaleh - All Rights Reserved
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
    $(document).ready(function() {
        // Initialize AOS animation
        AOS.init();
        
        // Toggle password visibility
        $('.toggle-password').click(function() {
            const passwordField = $(this).closest('.form-group').find('input');
            const icon = $(this).find('i');
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        
        // Handle login form submission
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?= site_url('auth/login') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'animate__animated animate__fadeInUp'
                            }
                        }).then(function() {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            customClass: {
                                popup: 'animate__animated animate__shakeX'
                            }
                        });
                        $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i> Masuk');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan pada server!',
                        customClass: {
                            popup: 'animate__animated animate__shakeX'
                        }
                    });
                    $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i> Masuk');
                }
            });
        });
        
        // Add floating effect to decorative elements
        function floatAnimation() {
            $('.decoration-1').animate({
                top: '-40px'
            }, 3000, function() {
                $('.decoration-1').animate({
                    top: '-30px'
                }, 3000, function() {
                    floatAnimation();
                });
            });
            
            $('.decoration-2').animate({
                bottom: '-60px'
            }, 4000, function() {
                $('.decoration-2').animate({
                    bottom: '-50px'
                }, 4000, function() {
                    floatAnimation();
                });
            });
        }
        
        floatAnimation();
    });
    </script>
</body>
</html>
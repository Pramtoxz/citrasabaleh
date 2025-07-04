<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Wisma Citra Sabaleh</title>
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
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
        
        .register-container {
            display: flex;
            min-height: 100vh;
        }
        
        .register-image {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') center/cover no-repeat;
            position: relative;
            box-shadow: 0 0 30px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .register-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
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
        
        .register-form-container {
            flex: 1.2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .register-form-wrapper {
            width: 100%;
            max-width: 600px;
            padding: 2.5rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .register-form-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .register-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .register-logo img {
            width: 100px;
            height: 100px;
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
        
        .register-footer {
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
        
        .invalid-feedback {
            display: block;
            margin-left: 45px;
            margin-top: 5px;
        }
        
        /* Steps indicator */
        .steps-container {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
            flex: 1;
            max-width: 120px;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #adb5bd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
            transition: all var(--transition-speed);
        }
        
        .step-text {
            font-size: 0.8rem;
            color: #6c757d;
            text-align: center;
            transition: all var(--transition-speed);
        }
        
        .step.active .step-icon {
            background-color: var(--primary-color);
            color: white;
        }
        
        .step.active .step-text {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .step.completed .step-icon {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .step-connector {
            position: absolute;
            top: 20px;
            height: 2px;
            background-color: #e9ecef;
            width: 100%;
            left: 50%;
            z-index: 1;
        }
        
        .step:first-child .step-connector {
            width: 50%;
            left: 50%;
        }
        
        .step:last-child .step-connector {
            width: 50%;
            right: 50%;
        }
        
        .step.active .step-connector, .step.completed .step-connector {
            background-color: var(--secondary-color);
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
            .register-image {
                display: none;
            }
            
            .register-form-container {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .register-form-wrapper {
                padding: 2rem 1.5rem;
            }
            
            .brand-title {
                font-size: 1.8rem;
            }
            
            .steps-container {
                flex-wrap: wrap;
            }
            
            .step {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Side: Image with Overlay Text -->
        <div class="register-image d-none d-lg-flex" data-aos="fade-right" data-aos-duration="1000">
            <div class="image-content">
                <h2>Bergabunglah dengan Wisma Citra Sabaleh</h2>
                <p>Daftar sekarang untuk mendapatkan pengalaman menginap terbaik dan penawaran khusus dari kami.</p>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-white bg-opacity-25 rounded-3 text-center">
                            <i class="fas fa-percent fa-2x mb-2 text-warning"></i>
                            <h6>Diskon Khusus</h6>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-white bg-opacity-25 rounded-3 text-center">
                            <i class="fas fa-gift fa-2x mb-2 text-warning"></i>
                            <h6>Poin Reward</h6>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-white bg-opacity-25 rounded-3 text-center">
                            <i class="fas fa-bed fa-2x mb-2 text-warning"></i>
                            <h6>Booking Prioritas</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Register Form -->
        <div class="register-form-container">
            <div class="register-form-wrapper" data-aos="fade-up" data-aos-duration="800">
                <div class="decoration-element decoration-1"></div>
                <div class="decoration-element decoration-2"></div>
                
                <div class="register-logo">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Wisma Citra Sabaleh" onerror="this.src='https://via.placeholder.com/100x100?text=WISMA'">
                </div>
                
                <h1 class="brand-title text-center">Wisma Citra Sabaleh</h1>
                <p class="brand-subtitle text-center">Daftar Akun Baru</p>
                
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <!-- Steps indicator -->
                <div class="steps-container mb-4">
                    <div class="step active">
                        <div class="step-connector"></div>
                        <div class="step-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="step-text">Informasi Akun</div>
                    </div>
                    <div class="step">
                        <div class="step-connector"></div>
                        <div class="step-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="step-text">Verifikasi Email</div>
                    </div>
                    <div class="step">
                        <div class="step-connector"></div>
                        <div class="step-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="step-text">Selesai</div>
                    </div>
                </div>
                
                <form action="<?= site_url('auth/register') ?>" method="post" class="fade-in-up" style="animation-delay: 0.3s;">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('username')) ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ?>" placeholder="Username" required>
                                <?php if (isset($validation) && $validation->hasError('username')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('username') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="Email" required>
                                <?php if (isset($validation) && $validation->hasError('email')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password position-absolute end-0 top-0 mt-2 me-2" style="height: 46px; width: 46px; border-radius: 8px;">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if (isset($validation) && $validation->hasError('password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control <?= (isset($validation) && $validation->hasError('password_confirm')) ? 'is-invalid' : '' ?>" id="password_confirm" name="password_confirm" placeholder="Konfirmasi Password" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password position-absolute end-0 top-0 mt-2 me-2" style="height: 46px; width: 46px; border-radius: 8px;">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password_confirm') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                            <label class="form-check-label" for="agree">
                                Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat dan Ketentuan</a>
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4 fade-in-up" style="animation-delay: 0.5s;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                        </button>
                    </div>
                </form>
                
                <div class="auth-links fade-in-up" style="animation-delay: 0.7s;">
                    Sudah punya akun? <a href="<?= site_url('auth') ?>">Login</a>
                </div>
                
                <div class="register-footer fade-in-up" style="animation-delay: 0.9s;">
                    &copy; <?= date('Y') ?> Wisma Citra Sabaleh - All Rights Reserved
                </div>
            </div>
        </div>
    </div>
    
    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="modal-title" id="termsModalLabel">Syarat dan Ketentuan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="text-primary">1. Pendaftaran Akun</h6>
                    <p>Dengan mendaftar di Wisma Citra Sabaleh, Anda menyatakan bahwa semua informasi yang Anda berikan adalah benar dan akurat.</p>
                    
                    <h6 class="text-primary">2. Privasi</h6>
                    <p>Kami akan menjaga kerahasiaan data pribadi Anda sesuai dengan Kebijakan Privasi kami.</p>
                    
                    <h6 class="text-primary">3. Penggunaan Akun</h6>
                    <p>Anda bertanggung jawab untuk menjaga kerahasiaan kredensial akun Anda dan semua aktivitas yang terjadi di bawah akun Anda.</p>
                    
                    <h6 class="text-primary">4. Pemesanan dan Pembayaran</h6>
                    <p>Pemesanan kamar hanya akan dikonfirmasi setelah pembayaran diterima. Pembatalan dan pengembalian dana akan mengikuti kebijakan yang berlaku.</p>
                    
                    <h6 class="text-primary">5. Pembatasan</h6>
                    <p>Kami berhak untuk membatasi atau menghentikan akun Anda jika terdapat pelanggaran terhadap syarat dan ketentuan ini.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('agree').checked = true;">Setuju</button>
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
        
        // Password strength check
        $('#password').on('input', function() {
            const password = $(this).val();
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 1;
            
            const strengthBar = $('.password-strength-bar');
            
            switch (strength) {
                case 0:
                case 1:
                    $(this).css('border-color', '#dc3545');
                    break;
                case 2:
                    $(this).css('border-color', '#ffc107');
                    break;
                case 3:
                    $(this).css('border-color', '#fd7e14');
                    break;
                case 4:
                    $(this).css('border-color', '#20c997');
                    break;
                case 5:
                    $(this).css('border-color', '#198754');
                    break;
            }
        });
    });
    </script>
</body>
</html>
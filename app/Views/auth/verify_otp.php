<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Wisma Citra Sabaleh</title>
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
        
        .otp-container {
            display: flex;
            min-height: 100vh;
        }
        
        .otp-image {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1621293954908-907159247fc8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') center/cover no-repeat;
            position: relative;
            box-shadow: 0 0 30px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .otp-image::before {
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
        
        .otp-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .otp-form-wrapper {
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .otp-form-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .otp-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .otp-logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 50%;
            padding: 5px;
            border: 2px solid var(--secondary-color);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .otp-input {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 30px 0;
        }
        
        .otp-input input {
            width: 60px;
            height: 70px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            border-radius: 8px;
            border: 2px solid #ddd;
            background-color: var(--light-color);
            color: var(--primary-color);
            transition: all var(--transition-speed);
        }
        
        .otp-input input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(139, 90, 43, 0.25);
            outline: none;
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
        
        .timer {
            font-size: 18px;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .resend-link {
            cursor: pointer;
            color: var(--primary-color);
            text-decoration: underline;
            font-weight: 500;
            transition: all var(--transition-speed);
        }
        
        .resend-link:hover {
            color: var(--secondary-color);
        }
        
        .resend-link.disabled {
            color: #6c757d;
            cursor: not-allowed;
            text-decoration: none;
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
        
        .otp-footer {
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
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .otp-image {
                display: none;
            }
            
            .otp-form-container {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .otp-form-wrapper {
                padding: 2rem 1.5rem;
            }
            
            .brand-title {
                font-size: 1.8rem;
            }
            
            .otp-input {
                gap: 5px;
            }
            
            .otp-input input {
                width: 45px;
                height: 55px;
                font-size: 24px;
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
    <div class="otp-container">
        <!-- Left Side: Image with Overlay Text -->
        <div class="otp-image d-none d-lg-flex" data-aos="fade-right" data-aos-duration="1000">
            <div class="image-content">
                <h2>Verifikasi Email Anda</h2>
                <p>Kami telah mengirimkan kode OTP ke email Anda. Silakan masukkan kode tersebut untuk melanjutkan.</p>
                <div class="d-flex justify-content-center mt-4">
                    <div class="p-4 bg-white bg-opacity-25 rounded-4 text-center">
                        <i class="fas fa-shield-alt fa-3x mb-3 text-warning"></i>
                        <h5>Keamanan Terjamin</h5>
                        <p class="mb-0">Kami mengutamakan keamanan data Anda</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side: OTP Form -->
        <div class="otp-form-container">
            <div class="otp-form-wrapper" data-aos="fade-up" data-aos-duration="800">
                <div class="decoration-element decoration-1"></div>
                <div class="decoration-element decoration-2"></div>
                
                <div class="otp-logo">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Wisma Citra Sabaleh" onerror="this.src='https://via.placeholder.com/100x100?text=WISMA'">
                </div>
                
                <h1 class="brand-title text-center">Wisma Citra Sabaleh</h1>
                <p class="brand-subtitle text-center">Verifikasi OTP</p>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <!-- Steps indicator -->
                <div class="steps-container mb-4">
                    <div class="step completed">
                        <div class="step-connector"></div>
                        <div class="step-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="step-text">Informasi Akun</div>
                    </div>
                    <div class="step active">
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
                
                <div class="text-center mb-4 fade-in-up" style="animation-delay: 0.2s;">
                    <p class="mb-1">
                        <?php if ($type === 'register'): ?>
                            Kode OTP telah dikirim ke email Anda untuk verifikasi pendaftaran.
                        <?php else: ?>
                            Kode OTP telah dikirim ke email Anda untuk reset password.
                        <?php endif; ?>
                    </p>
                    <p class="fw-bold">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <?= substr($email, 0, 3) . '***' . substr($email, strpos($email, '@')) ?>
                    </p>
                </div>
                
                <form action="<?= site_url($action) ?>" method="post" class="fade-in-up" style="animation-delay: 0.3s;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="email" value="<?= $email ?>">
                    
                    <div class="otp-input">
                        <input type="text" class="form-control" name="otp[]" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
                        <input type="text" class="form-control" name="otp[]" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="form-control" name="otp[]" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="form-control" name="otp[]" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="form-control" name="otp[]" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="form-control" name="otp[]" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    </div>
                    
                    <div class="text-center mb-4 fade-in-up" style="animation-delay: 0.4s;">
                        <div class="timer pulse" id="timer">Kode berlaku selama: 10:00</div>
                        <div>
                            Tidak menerima kode? 
                            <span class="resend-link disabled" id="resendLink">Kirim Ulang</span>
                        </div>
                    </div>
                    
                    <div class="d-grid fade-in-up" style="animation-delay: 0.5s;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle me-2"></i> Verifikasi
                        </button>
                    </div>
                </form>
                
                <div class="auth-links fade-in-up" style="animation-delay: 0.7s;">
                    <a href="<?= site_url('auth') ?>" class="text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                    </a>
                </div>
                
                <div class="otp-footer fade-in-up" style="animation-delay: 0.9s;">
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
        
        // OTP input handling
        $('.otp-input input').on('keyup', function(e) {
            const key = e.keyCode || e.charCode;
            
            // If backspace key
            if (key === 8 || key === 46) {
                $(this).val('');
                $(this).prev('input').focus();
                return;
            }
            
            // Only allow numbers
            if (!/^\d+$/.test($(this).val())) {
                $(this).val('');
                return;
            }
            
            // Auto move to next input
            if ($(this).val().length === 1) {
                $(this).next('input').focus();
            }
        });
        
        // Handle paste event
        $('.otp-input input').on('paste', function(e) {
            e.preventDefault();
            
            // Get pasted data
            let pastedData = (e.originalEvent || e).clipboardData.getData('text/plain').trim();
            
            // Make sure we only have digits
            pastedData = pastedData.replace(/\D/g, '');
            
            // Populate inputs
            if (pastedData.length > 0) {
                const inputs = $('.otp-input input');
                for (let i = 0; i < Math.min(pastedData.length, inputs.length); i++) {
                    $(inputs[i]).val(pastedData[i]);
                }
                
                // Focus on the next empty input or the last one
                let focusIndex = Math.min(pastedData.length, inputs.length - 1);
                $(inputs[focusIndex]).focus();
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
        
        // Timer for OTP
        let timeLeft = 600; // 10 minutes in seconds
        const timerElement = document.getElementById('timer');
        const resendLink = document.getElementById('resendLink');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            timerElement.textContent = `Kode berlaku selama: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerElement.textContent = 'Kode OTP telah kedaluwarsa';
                timerElement.classList.remove('pulse');
                resendLink.classList.remove('disabled');
            }
            
            timeLeft--;
        }
        
        // Initial update
        updateTimer();
        
        // Update timer every second
        const timerInterval = setInterval(updateTimer, 1000);
        
        // Enable resend link after 1 minute
        setTimeout(function() {
            resendLink.classList.remove('disabled');
        }, 60000);
        
        // Resend OTP
        $('#resendLink').click(function() {
            if ($(this).hasClass('disabled')) {
                return;
            }
            
            $.ajax({
                url: '<?= site_url('auth/resend-otp') ?>',
                type: 'POST',
                data: {
                    email: '<?= $email ?>',
                    type: '<?= $type ?>'
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#resendLink').addClass('disabled').text('Mengirim...');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            customClass: {
                                popup: 'animate__animated animate__fadeInUp'
                            }
                        });
                        
                        // Reset timer
                        timeLeft = 600;
                        timerElement.classList.add('pulse');
                        clearInterval(timerInterval);
                        updateTimer();
                        setInterval(updateTimer, 1000);
                        
                        // Disable resend link for 1 minute
                        $('#resendLink').addClass('disabled').text('Kirim Ulang');
                        setTimeout(function() {
                            $('#resendLink').removeClass('disabled');
                        }, 60000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            customClass: {
                                popup: 'animate__animated animate__shakeX'
                            }
                        });
                        $('#resendLink').removeClass('disabled').text('Kirim Ulang');
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
                    $('#resendLink').removeClass('disabled').text('Kirim Ulang');
                }
            });
        });
        
        // Add focus effect
        $('.otp-input input').focus(function() {
            $(this).addClass('animate__animated animate__pulse');
        }).blur(function() {
            $(this).removeClass('animate__animated animate__pulse');
        });
    });
    </script>
</body>
</html>
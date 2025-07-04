<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;
use Config\Email as EmailConfig;

class EmailService {
    protected $email;
    protected $emailConfig;
    
    public function __construct() {
        $this->email = \Config\Services::email();
        $this->emailConfig = new EmailConfig();
    }
    
    /**
     * Kirim email OTP
     * 
     * @param string $recipientEmail
     * @param string $otpCode
     * @param string $type
     * @return bool
     */
    public function sendOTP(string $recipientEmail, string $otpCode, string $type): bool
    {
        $subject = ($type === 'register') ? 'Verifikasi Akun Anda' : 'Reset Password';
        $message = $this->getOtpEmailTemplate($recipientEmail, $otpCode, $type);
        
        $this->email->setFrom($this->emailConfig->fromEmail, $this->emailConfig->fromName);
        $this->email->setTo($recipientEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        return $this->email->send();
    }
    
    /**
     * Get HTML template untuk email OTP
     * 
     * @param string $email
     * @param string $otpCode
     * @param string $type
     * @return string
     */
    private function getOtpEmailTemplate(string $email, string $otpCode, string $type): string
    {
        $title = ($type === 'register') ? 'Verifikasi Akun Anda' : 'Reset Password';
        $message = ($type === 'register') 
            ? 'Terima kasih telah mendaftar. Gunakan kode OTP berikut untuk menyelesaikan proses pendaftaran.'
            : 'Kami menerima permintaan untuk reset password akun Anda. Gunakan kode OTP berikut untuk melanjutkan.';

        $template = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $title . '</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
        }
        .otp-code {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 5px;
            margin: 30px 0;
            padding: 15px;
            background-color: #f1f5ff;
            border-radius: 5px;
            border: 1px dashed #4e73df;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 30px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>' . $title . '</h2>
        </div>
        <div class="content">
            <p>Halo,</p>
            <p>' . $message . '</p>
            <div class="otp-code">' . $otpCode . '</div>
            <p>Kode OTP ini berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun.</p>
            <p>Jika Anda tidak melakukan permintaan ini, harap abaikan email ini.</p>
            <p>Terima kasih,<br>Tim Kami</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; ' . date('Y') . ' Aplikasi Kami. All rights reserved.</p>
        </div>
    </div>
</body>
</html>';

        return $template;
    }
} 
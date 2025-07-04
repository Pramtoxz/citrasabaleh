<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $table            = 'otp_codes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['email', 'otp_code', 'type', 'is_used', 'expires_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Generate OTP untuk email tertentu dan tipe tertentu
     *
     * @param string $email
     * @param string $type register|forgot_password
     * @return array
     */
    public function generateOTP(string $email, string $type): array
    {
        // Nonaktifkan OTP lama yang belum dipakai
        $this->where('email', $email)
            ->where('type', $type)
            ->where('is_used', 0)
            ->set(['is_used' => 1])
            ->update();
        
        // Generate OTP baru
        $otpCode = $this->generateRandomOTP();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        $data = [
            'email'      => $email,
            'otp_code'   => $otpCode,
            'type'       => $type,
            'is_used'    => 0,
            'expires_at' => $expiresAt,
        ];
        
        $this->insert($data);
        
        return [
            'email'      => $email,
            'otp_code'   => $otpCode,
            'expires_at' => $expiresAt,
        ];
    }
    
    /**
     * Verifikasi OTP yang dimasukkan pengguna
     *
     * @param string $email
     * @param string $otpCode
     * @param string $type
     * @return bool
     */
    public function verifyOTP(string $email, string $otpCode, string $type): bool
    {
        $now = date('Y-m-d H:i:s');
        
        $otp = $this->where('email', $email)
            ->where('otp_code', $otpCode)
            ->where('type', $type)
            ->where('is_used', 0)
            ->where('expires_at >', $now)
            ->first();
            
        if ($otp) {
            // Tandai OTP sebagai sudah digunakan
            $this->update($otp['id'], ['is_used' => 1]);
            return true;
        }
        
        return false;
    }
    
    /**
     * Cek apakah email sudah memiliki OTP yang valid
     *
     * @param string $email
     * @param string $type
     * @return bool
     */
    public function hasValidOTP(string $email, string $type): bool
    {
        $now = date('Y-m-d H:i:s');
        
        $count = $this->where('email', $email)
            ->where('type', $type)
            ->where('is_used', 0)
            ->where('expires_at >', $now)
            ->countAllResults();
            
        return $count > 0;
    }
    
    /**
     * Generate 6 digit OTP secara random
     *
     * @return string
     */
    private function generateRandomOTP(): string
    {
        return sprintf('%06d', mt_rand(0, 999999));
    }
    
    /**
     * Bersihkan OTP yang sudah kadaluarsa
     *
     * @return void
     */
    public function cleanupExpiredOTP(): void
    {
        $now = date('Y-m-d H:i:s');
        
        $this->where('expires_at <', $now)
            ->where('is_used', 0)
            ->set(['is_used' => 1])
            ->update();
    }
} 
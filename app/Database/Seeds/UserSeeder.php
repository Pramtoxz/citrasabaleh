<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'manager',
                'email' => 'manager@example.com',
                'password' => password_hash('manager123', PASSWORD_DEFAULT),
                'role' => 'manager',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'inactive',
                'email' => 'inactive@example.com',
                'password' => password_hash('inactive123', PASSWORD_DEFAULT),
                'role' => 'user',
                'status' => 'inactive',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);

        // Output info
        echo "Seeder: User berhasil ditambahkan!\n";
        echo "----------------------------------------\n";
        echo "Daftar akun yang tersedia:\n";
        echo "1. Admin\n";
        echo "   Username: admin\n";
        echo "   Password: admin123\n";
        echo "2. Manager\n";
        echo "   Username: manager\n";
        echo "   Password: manager123\n";
        echo "3. User\n";
        echo "   Username: user\n";
        echo "   Password: user123\n";
        echo "4. Inactive User\n";
        echo "   Username: inactive\n";
        echo "   Password: inactive123\n";
        echo "----------------------------------------\n";
    }
}

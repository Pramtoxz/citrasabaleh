<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Truncate the table first to ensure clean data
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $this->call('UserSeeder');
    }
}

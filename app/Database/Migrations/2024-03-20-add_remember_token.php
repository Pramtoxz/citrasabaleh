<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRememberToken extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'remember_token' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'last_login'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'remember_token');
    }
}

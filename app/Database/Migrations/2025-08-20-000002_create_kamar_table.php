<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPSQLParser\builders\PrimaryKeyBuilder;

class CreateKamarTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'PrimaryKey' => true,
                'notnull' => true
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'harga' => [
                'type'       => 'DOUBLE',
                'constraint' => '10,2',
            ],
             'status_kamar' => [
                'type'       => 'ENUM',
                'constraint' => [1, 2],
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->createTable('kamar');

        // Tambahkan admin default
        $data = [
            'id'   => 1,
            'nama'   => 'Kamar 101',
            'harga'      => 500000,
            'status_kamar' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('kamar')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('kamar');
    }
}

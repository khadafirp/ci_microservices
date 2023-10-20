<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kategori_id' => [
                'type'=> 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'kategori_title' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null'=> true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null'=> true
            ]
        ]);
        $this->forge->addKey('kategori_id', true);
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}

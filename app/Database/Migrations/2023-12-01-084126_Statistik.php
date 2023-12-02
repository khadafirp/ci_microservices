<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Statistik extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'statistik_id' => [
                    'type'           => 'INT',
                    'constraint'     => 5,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'news_id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true
                ],
                'kategori_id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true
                ],
                'tahun' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20
                ],
                'bulan' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20
                ],
                'tanggal' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20
                ],
                'created_at' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20
                ],
                'updated_at' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20
                ]
            ]
        );

        $this->forge->addKey('statistik_id');
        $this->forge->createTable('statistik');
    }

    public function down()
    {
        $this->forge->dropTable('statistik');
    }
}

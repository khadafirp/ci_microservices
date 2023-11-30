<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Berita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'news_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kategori_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'news_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'news_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'filename' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'filesize' => [
                'type'       => 'INT',
                'null' => true
            ],
            'path' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('news_id', true);
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}

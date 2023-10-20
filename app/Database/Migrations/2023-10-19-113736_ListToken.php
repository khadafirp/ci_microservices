<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ListToken extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'token_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'pengguna_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
            'token' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'exp_time' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
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
        $this->forge->addKey('token_id', true);
        $this->forge->createTable('list_token');
    }

    public function down()
    {
        $this->forge->dropTable('list_token');
    }
}

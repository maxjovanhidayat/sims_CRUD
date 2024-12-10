<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',  
                'null' => false,
            ],
            'image_profile' => [
                'type' => 'VARCHAR',
                'constraint' => '255',  
                'null' => true,  
            ],
            'position' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
        
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}

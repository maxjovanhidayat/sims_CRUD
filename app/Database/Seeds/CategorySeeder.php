<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        
        $data = [
            [
                'nama_kategori' => 'Olahraga',
            ],
            [
                'nama_kategori' => 'Alat Musik',
            ]
        ];

        // Using Query Builder
        $this->db->table('category')->insertBatch($data);
    }
}

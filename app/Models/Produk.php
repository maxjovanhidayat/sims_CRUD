<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Category;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_image',
        'product_name',
        'category_id',
        'harga_beli',
        'harga_jual',
        'stok'
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    // Validation rules
    protected $validationRules = [
        'product_name' => 'required|min_length[3]|max_length[255]',
        'category_id' => 'required|is_not_unique[category.id]',
        'harga_beli' => 'required|numeric',
        'harga_jual' => 'required|numeric',
        'stok' => 'required|numeric',
    ];

    // Custom validation messages
    protected $validationMessages = [
        'product_name' => [
            'required' => 'Nama produk harus diisi.',
            'min_length' => 'Nama produk minimal 3 karakter.',
            'max_length' => 'Nama produk maksimal 255 karakter.'
        ],
        'category_id' => [
            'required' => 'Kategori harus dipilih.',
            'is_not_unique' => 'Kategori yang dipilih tidak valid.'
        ],
        'harga_beli' => [
            'required' => 'Harga beli harus diisi.',
            'numeric' => 'Harga beli harus berupa angka.'
        ],
        'harga_jual' => [
            'required' => 'Harga jual harus diisi.',
            'numeric' => 'Harga jual harus berupa angka.'
        ],
        'stok' => [
            'required' => 'Stok harus diisi.',
            'numeric' => 'Stok harus berupa angka.'
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}

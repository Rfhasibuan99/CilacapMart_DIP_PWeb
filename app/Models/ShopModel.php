<?php

namespace App\Models;

use CodeIgniter\Model;

class ShopModel extends Model
{
    protected $table = 'shop';
    protected $primaryKey = 'id_toko';
    protected $allowedFields = ['nama_toko', 'deskripsi', 'alamat', 'nomor', 'jam', 'gambar'];
}
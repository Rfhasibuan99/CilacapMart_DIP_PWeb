<?php

namespace App\Models;

use CodeIgniter\Model;

class ShopModel extends Model
{
    protected $table = 'shop';
    protected $primaryKey = 'id_toko';
    protected $allowedFields = ['nama_barang', 'deskripsi', 'alamat', 'nomor', 'jam', 'harga_barang', 'gambar'];
}
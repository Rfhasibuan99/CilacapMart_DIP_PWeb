<?php

namespace App\Models;

use CodeIgniter\Model;
class ShopModel extends Model
{
    protected $table = 'shop';
    protected $primaryKey = 'id_toko';
    protected $allowedFields = [
        'nama_toko',
        'deskripsi',
        'nomor',
        'jam',
        'gambar',
    ];
    public function getShop($idshop = false)
    {
        if ($idshop == false) {
            return $this->findAll();
        }

        return $this->where(['id_toko' => $idshop])->first();
    }
    public function findShop($cari)
    {
        return $this
            ->like('nama_toko', $cari)
            ->orLike('deskripsi', $cari)
            ->orLike('nomor', $cari)
            ->orLike('jam', $cari);
    }
}
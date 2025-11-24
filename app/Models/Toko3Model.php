<?php

namespace App\Models;

use CodeIgniter\Model;

class Toko3Model extends Model
{
    protected $table = 'toko3';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['nama_barang', 'jenis_barang', 'deskripsi', 'gambar', 'stok', 'harga_beli', 'harga_jual'];

    // getBarang
    public function getBarang($idbarang = false)
    {
        if ($idbarang == false) {
            return $this->findAll();
        }

        return $this->where(['id_barang' => $idbarang])->first();
    }

    // findBarang / pencarian
    public function findBarang($cari)
    {
        return $this
            ->like('nama_barang', $cari)
            ->orLike('jenis_barang', $cari)
            ->orLike('deskripsi', $cari)
            ->orLike('stok', $cari)
            ->orLike('harga_beli', $cari)
            ->orLike('harga_jual', $cari);
    }
}

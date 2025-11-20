<?php

namespace App\Models;

use CodeIgniter\Model;

class Toko1Model extends Model
{
    protected $table = 'toko1';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['nama_barang', 'jenis_barang', 'harga_barang', 'deskripsi', 'gambar'];

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
            ->orLike('harga_barang', $cari)
            ->orLike('deskripsi', $cari);
    }
}

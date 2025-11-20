<?php

namespace App\Models;

use CodeIgniter\Model;

class Toko2Model extends Model
{
    protected $table = 'toko2';
    protected $primaryKey = 'id_barang';
    protected $useTimestamps = false;
    protected $allowedFields = ['nama_barang', 'jenis_barang', 'harga_barang', 'deskripsi', 'gambar'];
    
    public function getBarang($idbarang = false)
    {
        if ($idbarang == false) {
            return $this->findAll();
        }
        return $this->where(['id_barang' => $idbarang])->first();
    }

    public function findBarang($cari)
    {
        return $this->like('nama_barang', $cari)
                    ->orLike('jenis_barang', $cari)
                    ->orLike('harga_barang', $cari)
                    ->findAll();
    }
}
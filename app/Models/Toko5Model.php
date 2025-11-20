<?php

namespace App\Models;

use CodeIgniter\Model;

class Toko5Model extends Model
{
    protected $table = 'toko4';
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
        return $this->table('toko5')->like('nama_barang', $cari)
                                    ->orlike('jenis_barang', $cari)
                                    ->orlike('harga_barang', $cari);
    }
}
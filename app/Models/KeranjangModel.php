<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $allowedFields = ['id_user', 'id_barang', 'jumlah'];

    public function getKeranjangWithBarang($idUser)
    {
        return $this->select('keranjang.*, barang.nama_barang, barang.harga_jual, barang.gambar')
                    ->join('barang', 'barang.id_barang = keranjang.id_barang')
                    ->where('keranjang.id_user', $idUser)
                    ->findAll();
    }
}

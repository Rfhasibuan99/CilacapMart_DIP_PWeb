<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_pesanan', 'id_barang', 'jumlah', 'harga_satuan', 'subtotal'
    ];

    public function getDetailByPesanan($idPesanan)
    {
        return $this->select('detail_pesanan.*, barang.nama_barang, barang.gambar')
            ->join('barang', 'barang.id_barang = detail_pesanan.id_barang')
            ->where('id_pesanan', $idPesanan)
            ->findAll();
    }
}

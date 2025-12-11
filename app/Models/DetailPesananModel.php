<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_pesanan', 'id_barang',
        'harga_barang', 'jumlah', 'subtotal'
    ];

    public function getDetailByPesananId($id_pesanan)
    {
        return $this->select('detail_pesanan.*, barang.nama_barang')
            ->join('barang', 'barang.id_barang = detail_pesanan.id_barang')
            ->where('detail_pesanan.id_pesanan', $id_pesanan)
            ->findAll();
    }
}
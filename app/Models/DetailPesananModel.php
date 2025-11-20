<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_pesanan',
        'id_barang',
        'nama_barang',
        'harga_barang',
        'jumlah',
        'subtotal'
    ];

    // Get detail by pesanan
    public function getDetailByPesanan($idPesanan)
    {
        return $this->where('id_pesanan', $idPesanan)->findAll();
    }

    // Get detail with barang info
    public function getDetailWithBarang($idPesanan)
    {
        return $this->select('detail_pesanan.*, barang.gambar')
            ->join('barang', 'barang.id_barang = detail_pesanan.id_barang')
            ->where('detail_pesanan.id_pesanan', $idPesanan)
            ->findAll();
    }
}

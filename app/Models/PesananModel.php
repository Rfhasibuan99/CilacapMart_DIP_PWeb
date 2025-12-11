<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $allowedFields = [
        'id_user', 'kode_pesanan',
        'tanggal_pesan', 'subtotal', 'ongkir', 'diskon', 'total_harga', 'status',
        'metode_pembayaran', 'metode_pengiriman',
        'penerima_pesanan', 'telp_pesanan', 'alamat_lengkap_pesanan'
    ];
    public function getPesananWithDetails($idPesanan)
    {
        return $this->select('pesanan.*')
            ->where('id_pesanan', $idPesanan)
            ->first();
    }

    public function getPesananByUser($idUser)
    {
        return $this->where('id_user', $idUser)
            ->orderBy('tanggal_pesan', 'DESC')
            ->findAll();
    }
}

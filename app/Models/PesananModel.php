<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $allowedFields = [
        'id_user', 'kode_pesanan', 'alamat_pengiriman',
        'tanggal_pesan', 'total_harga', 'status'
    ];

    // Ambil pesanan berdasarkan ID + detail user
    public function getPesananWithDetails($idPesanan)
    {
        return $this->select('pesanan.*')
            ->where('id_pesanan', $idPesanan)
            ->first();
    }

    // Ambil semua pesanan milik user
    public function getPesananByUser($idUser)
    {
        return $this->where('id_user', $idUser)
            ->orderBy('tanggal_pesan', 'DESC')
            ->findAll();
    }
}

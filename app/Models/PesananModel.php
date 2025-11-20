<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $allowedFields = [
        'id_user',
        'tanggal_pesanan',
        'total_harga',
        'status',
        'alamat_pengiriman'
    ];
    protected $useTimestamps = true;

    // Relasi dengan detail pesanan
    public function getPesananWithDetails($idPesanan = false)
    {
        if ($idPesanan === false) {
            return $this->findAll();
        }

        return $this->where(['id_pesanan' => $idPesanan])->first();
    }

    // Get pesanan by user
    public function getPesananByUser($idUser)
    {
        return $this->where('id_user', $idUser)->findAll();
    }

    // Update status pesanan
    public function updateStatus($idPesanan, $status)
    {
        return $this->update($idPesanan, ['status' => $status]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_pesanan',
        'metode_pembayaran',
        'tanggal_bayar',
        'jumlah_bayar',
        'status_pembayaran',
        'kode_transaksi',
        'bukti_transfer',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'id_pesanan'        => 'required|integer',
        'metode_pembayaran' => 'required|max_length[50]',
        'jumlah_bayar'      => 'required|numeric',
        'status_pembayaran' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    public function getPaymentByOrderId(int $id_pesanan)
    {
        return $this->where('id_pesanan', $id_pesanan)->first();
    }
}
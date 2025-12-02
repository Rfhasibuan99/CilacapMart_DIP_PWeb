<?php
namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_bayar';
    protected $allowedFields = ['id_pesanan', 'metode', 'jumlah', 'status'];
}

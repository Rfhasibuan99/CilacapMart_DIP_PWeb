<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $allowedFields = [
        'id_user',
        'id_barang',
        'id_toko',
        'jumlah',
        'added_at'
    ];
    protected $useTimestamps = false;
}

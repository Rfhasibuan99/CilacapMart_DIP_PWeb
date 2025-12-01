<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'Keranjang';
    protected $primaryKey = 'id_Keranjang';
    protected $allowedFields = ['id_toko', 'user_id', 'id_barang', 'jumlah'];
}

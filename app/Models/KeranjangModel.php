<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_Keranjang';
    protected $allowedFields = ['id_user', 'id_toko', 'id_barang', 'jumlah'];
}

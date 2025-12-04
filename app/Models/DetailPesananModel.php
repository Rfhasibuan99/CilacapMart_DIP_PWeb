<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_pesanan', 'id_barang', 'nama_barang', 
        'jumlah', 'harga_satuan', 'subtotal'
    ];
    
    // Asumsi: Anda memiliki KeranjangModel dan BarangModel yang akan digunakan
}
<?php namespace App\Models;

use CodeIgniter\Model;

class SaranModel extends Model
{
    protected $table      = 'saran';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Pastikan field ini sesuai dengan kolom tabel Anda (termasuk users_id)
    protected $allowedFields = [
        'users_id', 'username', 'kategori', 
        'judul_saran', 'deskripsi', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $dateFormat    = 'datetime'; 
}
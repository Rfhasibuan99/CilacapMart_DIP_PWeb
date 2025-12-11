<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'role', 'nama_pengguna', 'alamat',
        'no_tlp', 'jenis_kelamin', 'tgl_lahir', 'gambar', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $returnType = 'array';

    public function getAkunById($id)
    {
        return $this->where('id', $id)->first();
    }
}

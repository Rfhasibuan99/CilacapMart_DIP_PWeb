<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BarangModel;

class BarangApi extends ResourceController
{
    // Menggunakan ResponseTrait bawaan CI4 untuk API
    use \CodeIgniter\API\ResponseTrait; 

    public function getBarang()
    {
        $model = new BarangModel();
        $data  = $model->findAll();

        // Mengembalikan data JSON murni, siap dibaca oleh Flutter
        return $this->respond([
            'status' => true,
            'data'   => $data
        ], 200);
    }
}
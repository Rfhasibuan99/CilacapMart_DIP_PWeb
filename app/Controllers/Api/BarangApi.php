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
    public function tambahBarang()
{
    $model = new BarangModel();

    $body = $this->request->getBody();
    $json = json_decode($body);

    $data = [
        'nama_barang'  => $json->nama_barang,
        'jenis_barang' => $json->jenis_barang,
        'gambar'       => $json->gambar,
        'deskripsi'    => $json->deskripsi,
        'harga_jual'   => $json->harga_jual,
        'harga_beli'   => $json->harga_beli,
        'stok'         => $json->stok,
    ];

    $model->insert($data);

    return $this->respond([
        'status' => true,
        'message' => 'Barang berhasil ditambahkan',
        'data' => $data
    ], 201);
}
public function hapusBarang($id)
{
    $model = new BarangModel();

    $barang = $model->find($id);

    if (!$barang) {
        return $this->respond([
            'status' => false,
            'message' => 'Barang tidak ditemukan'
        ], 404);
    }

    $model->delete($id);

    return $this->respond([
        'status' => true,
        'message' => 'Barang berhasil dihapus'
    ]);
}
public function updateBarang($id)
{
    $model = new BarangModel();

    $body = $this->request->getBody();
    $json = json_decode($body);

    $data = [
        'nama_barang'  => $json->nama_barang,
        'jenis_barang' => $json->jenis_barang,
        'gambar'       => $json->gambar,
        'deskripsi'    => $json->deskripsi,
        'harga_jual'   => $json->harga_jual,
        'harga_beli'   => $json->harga_beli,
        'stok'         => $json->stok,
    ];

    $model->update($id, $data);

    return $this->respond([
        'status' => true,
        'message' => 'Barang berhasil diupdate'
    ]);
}
}
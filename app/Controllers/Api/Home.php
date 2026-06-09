<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BarangModel;

class Home extends ResourceController
{
    use \CodeIgniter\API\ResponseTrait;

    public function index()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            return $this->response->setStatusCode(200);
        }

        $barangModel = new BarangModel();
        $daftarBarangRaw = $barangModel->getBarang(); 

        // PAKSA KONVERSI TIPE DATA BARANG DARI DATABASE DI SINI:
        $daftarBarangFix = [];
        if (!empty($daftarBarangRaw)) {
            foreach ($daftarBarangRaw as $row) {
                $daftarBarangFix[] = [
                    'id_barang'    => $row['id_barang'] ?? null,
                    'nama_barang'  => $row['nama_barang'] ?? 'Tanpa Nama',
                    'jenis_barang' => $row['jenis_barang'] ?? '',
                    'deskripsi'    => $row['deskripsi'] ?? '',
                    'gambar'       => $row['gambar'] ?? '',
                    // Mengubah string angka dari database menjadi int murni untuk Flutter
                    'stok'         => isset($row['stok']) ? (int)$row['stok'] : 0,
                    'harga_beli'   => isset($row['harga_beli']) ? (int)$row['harga_beli'] : 0,
                    'harga_jual'   => isset($row['harga_jual']) ? (int)$row['harga_jual'] : 0,
                ];
            }
        }

        $kategori = [
            ["nama" => "Minuman", "gambar" => "Minuman.jpg"],
            ["nama" => "Makanan", "gambar" => "Makanan.jpg"],
            ["nama" => "Fashion", "gambar" => "Fashion.jpg"],
            ["nama" => "Barang Kerajinan", "gambar" => "BarangKerajinan.jpg"],
            ["nama" => "Accessories", "gambar" => "Accesories.jpg"],
            ["nama" => "Bahan Baku", "gambar" => "BahanBaku.jpg"]
        ];

        $baseUrlImage = base_url(); 
        $banners = [
            $baseUrlImage . "img/slide1.jpg",
            $baseUrlImage . "img/slide2.jpg",
            $baseUrlImage . "img/slide3.jpg",
        ];

        // Kirim response JSON dengan status bertipe boolean asli (true)
        return $this->respond([
            'status'  => true,
            'message' => 'Data Beranda CilacapMart Berhasil Dimuat',
            'data'    => [
                'banners'    => $banners,
                'categories' => $kategori,
                'products'   => $daftarBarangFix // Data yang sudah dijinakkan tipe datanya
            ]
        ], 200);
    }
}
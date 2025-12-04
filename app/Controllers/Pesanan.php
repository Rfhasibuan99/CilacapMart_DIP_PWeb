<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $detailPesananModel;
    protected $user_id = 1; 

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->detailPesananModel = new DetailPesananModel();
    }

    // pesanan/index
    public function index()
    {
        // Mengambil semua pesanan milik user yang sedang login
        $pesanan = $this->pesananModel->getPesananByUser($this->user_id);

        $data = [
            'title' => 'Daftar Pesanan Saya',
            'pesanan' => $pesanan,
        ];

        return view('pesanan/index', $data);
    }

    // pesanan/detail/[id]
    public function detail($id_pesanan)
    {
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil detail item dari pesanan tersebut
        $detail = $this->detailPesananModel->getDetailByPesananId($id_pesanan);
        
        $data = [
            'title' => 'Detail Pesanan',
            'pesanan' => $pesanan,
            'detail' => $detail,
        ];

        return view('pesanan/detail', $data);
    }
}
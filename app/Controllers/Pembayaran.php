<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PesananModel;

class Pembayaran extends Controller
{
    protected $pesananModel;
    protected $session;
    protected $user_id;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->pesananModel = new PesananModel();
        $this->user_id = user_id() ?? 1; 
    }

    public function index()
    {
        $pesanan_menunggu = $this->pesananModel
                             ->where('id_user', $this->user_id)
                             ->where('status', 'Menunggu Pembayaran')
                             ->findAll();
        
        $data = [
            'title' => 'Daftar Pembayaran yang Tertunda',
            'pesanan' => $pesanan_menunggu,
        ];

        return view('pembayaran/index', $data);
    }

    public function show($id_pesanan)
{
    $pesanan = $this->pesananModel->find($id_pesanan);



    if ($pesanan['status'] !== 'Menunggu Pembayaran') {
         return redirect()->to(base_url('pesanan/detail/' . $pesanan['id_pesanan']))->with('info', 'Pembayaran sudah diproses atau pesanan dibatalkan.');
    }
    

    $totalFinal = $pesanan['total_harga'] ?? 0;
    
    $data = [
        'title' => 'Instruksi Pembayaran',
        'pesanan' => $pesanan,
        'totalFinal' => $totalFinal,
    ];

    return view('pembayaran/show', $data);
}
    
    public function update_status()
    {
        $id_pesanan = $this->request->getPost('id_pesanan');
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            return redirect()->to(base_url('pesanan'))->with('error', 'Pesanan tidak valid.');
        }

        if ($pesanan['status'] == 'Menunggu Pembayaran') {
            $this->pesananModel->update($id_pesanan, [
                'status' => 'Diproses',
                'tanggal_bayar' => date('Y-m-d H:i:s')
            ]);

            return redirect()->to(base_url('pesanan/detail/' . $id_pesanan))->with('success', 'Konfirmasi pembayaran berhasil. Pesanan Anda sedang diproses!');
        }
        
        return redirect()->to(base_url('pesanan/detail/' . $id_pesanan))->with('info', 'Status pesanan sudah diperbarui sebelumnya.');
    }
}
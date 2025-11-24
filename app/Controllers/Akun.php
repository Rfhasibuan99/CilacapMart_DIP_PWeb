<?php

namespace App\Controllers;
use App\Models\AkunModel;

class Akun extends BaseController
{
    protected $akunModel;
    public function __construct()
    {
        $this->akunModel = new AkunModel();

    }
    // ======================
    // INDEX - DAFTAR AKUN
 public function index()
    {
        $akunModel = new AkunModel();

        // contoh ambil user berdasarkan id login
        $userId = session()->get('id');

        $data['user'] = $this->akunModel->where('id', $userId)->findAll();

        return view('akun/index', $data);
    }

    public function edit()
    {
        return view('akun/edit');
    }

    public function update()
    {
        // Logika untuk update akun
        // Misalnya update username, email, dll.
        // Untuk sementara, redirect kembali dengan pesan
        session()->setFlashdata('pesan', 'Akun berhasil diupdate');
        return redirect()->to('/akun');
    }

}

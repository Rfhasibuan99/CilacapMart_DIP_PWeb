<?php

namespace App\Controllers;

class Akun extends BaseController
{
    public function index()
    {
        return view('akun/index');
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

<?php
namespace App\Controllers;

use App\Models\AkunModel;

class Akun extends BaseController
{
    public function index()
    {
        $user = user(); // ← ambil user Myth/Auth

        return view('akun/index', [
            'title' => 'Akun Saya',
            'user'  => $user
        ]);
    
    }

    public function ubah()
    {
        $user = user(); // ← user aktif

        return view('akun/ubah', [
            'title' => 'Ubah Akun',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update()
    {
        $akunModel = new AkunModel();
        $user = user(); // ← user aktif

        $id = $user->id; // ← ID user dari Myth/Auth

        $akunModel->update($id, [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ]);

        return redirect()->to('/akun')->with('success', 'Profil berhasil diperbarui.');
    }
}

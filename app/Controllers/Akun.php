<?php
namespace App\Controllers;

use App\Models\AkunModel;

class Akun extends BaseController
{

    public function index()
    {
        $user = user(); // ← ambil user Myth/Auth
        if (!$user) {
            return redirect()->to('/login'); 
        }
        $AkunModel = new AkunModel();
        $userData = $AkunModel->getAkunById($user->id); // Get full user data including gambar

        return view('akun/index', [
            'title' => 'Akun Saya',
            'user'  => $userData
        ]);

    }

    public function ubah()
    {
        $user = user(); // ← user aktif
        $AkunModel = new AkunModel();
        $userData = $AkunModel->getAkunById($user->id);

        return view('akun/ubah', [
            'title' => 'Ubah Akun',
            'user' => $userData,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update()
    {
        $user = user(); // ← user aktif
        $id = $user->id; // ← ID user dari Myth/Auth
        $AkunModel = new AkunModel();
        $dataLama = $AkunModel->getAkunById($id);

        // Validasi input
        $rules = [
            'email' => 'required|valid_email',
            'nama_pengguna' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'gambar' => 'permit_empty|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $gambarLama = $dataLama['gambar'] ?? null;
        $namaGambar = $gambarLama; // default to old image

        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            // Generate new filename
            $namaGambar = $fileGambar->getRandomName();

            // Move file to img directory
            $fileGambar->move('img', $namaGambar);

            // Delete old image if exists
            if ($gambarLama && file_exists('img/' . $gambarLama)) {
                unlink('img/' . $gambarLama);
            }
        }

        // Update database
        $AkunModel->update($id, [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'alamat' => $this->request->getPost('alamat'),
            'no_tlp' => $this->request->getPost('no_tlp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'gambar' => $namaGambar,
        ]);

        return redirect()->to('/akun')->with('success', 'Profil berhasil diperbarui.');
    }
}

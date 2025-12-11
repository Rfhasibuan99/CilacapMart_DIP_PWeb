<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaranModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Saran extends BaseController
{
    protected $saranModel;

    public function __construct()
    {
        // Pastikan Anda memiliki helper 'form' dan helper untuk otentikasi (misalnya 'auth' atau 'user')
        helper(['form', 'url', 'auth']);
        $this->saranModel = new SaranModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Form Saran & Masukan',
            'validation' => \Config\Services::validation(),
            'kategori_list' => $this->getKategoriOpsiForForm(), // Menggunakan opsi form yang lebih lengkap
        ];
        // Pastikan view file ini ada di app/Views/saran/tambah.php
        return view('saran/index', $data);
    }

    public function simpan()
    {
        // 1. Definisikan Rule Validasi
        $rules = [
            'kategori' => 'required',
            'judul_saran' => 'required|max_length[255]',
            'deskripsi' => 'required|max_length[5000]',
        ];

        // 2. Lakukan Validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan input dan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Tentukan Detail Pengguna
        $usersId = null;
        $username = 'Anonim';

        // Cek apakah pengguna login dan tidak mencentang kotak 'anonim'
        if (logged_in() && $this->request->getPost('anonim') !== '1') {
            $user = user(); // Ambil objek pengguna saat ini
            $usersId = $user->id ?? null;
            $username = $user->username ?? 'Tamu Terdaftar';
        }

        // 4. Simpan Data
        $dataSimpan = [
            'users_id' => $usersId,
            'username' => $username,
            'kategori' => $this->request->getPost('kategori'),
            'judul_saran' => $this->request->getPost('judul_saran'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 'Baru',
        ];

        $this->saranModel->save($dataSimpan);

        // 5. Berikan Pesan Sukses dan Redirect
        session()->setFlashdata('pesan', 'Terima kasih! Saran Anda telah berhasil kami terima dan akan segera kami tinjau.');

        return redirect()->to(base_url('saran')); // Redirect ke halaman form saran
    }

    public function daftar()
    {
        // Cek otorisasi, hanya untuk admin
        if (!in_groups('admin')) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Ambil filter dari query string
        $kategoriFilter = $this->request->getVar('kategori');
        $statusFilter = $this->request->getVar('status');

        $builder = $this->saranModel;

        // Terapkan filter jika ada
        if ($kategoriFilter) {
            $builder = $builder->where('kategori', $kategoriFilter);
        }
        if ($statusFilter) {
            $builder = $builder->where('status', $statusFilter);
        }

        $data = [
            'title' => 'Daftar Saran & Masukan',
            // Ambil semua data dengan filter, urutkan berdasarkan created_at terbaru
            'saran_list' => $builder->orderBy('created_at', 'DESC')->findAll(),
            'kategori_aktif' => $kategoriFilter,
            'status_aktif' => $statusFilter,
            'kategori_opsi' => $this->getKategoriOpsiForForm() // Opsi untuk filter/form
        ];

        return view('saran/daftar', $data);
    }

    public function detail($id = null)
    {
        // Cek otorisasi, hanya untuk admin
        if (!in_groups('admin')) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Cari data saran
        $saran = $this->saranModel->find($id);

        if (!$saran) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Update status menjadi 'Dibaca' jika status sebelumnya 'Baru'
        if ($saran['status'] === 'Baru') {
            $this->saranModel->update($id, ['status' => 'Dibaca']);
            $saran['status'] = 'Dibaca'; // Update array untuk tampilan tanpa perlu reload
        }

        return view('saran/admin_detail', ['title' => 'Detail Saran', 'saran' => $saran]);
    }

    // Metode untuk menyediakan opsi kategori yang digunakan di form/filter
    private function getKategoriOpsiForForm()
    {
        return [
            'Peningkatan Fitur',
            'Masalah Teknis',
            'Kritik Layanan',
            'Belanja',
            'Pembayaran',
            'Pengiriman',
            'Lain-lain'
        ];
    }
    public function update_status($id = null)
    {
        if (!in_groups('admin') || !$this->request->is('post')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $saran = $this->saranModel->find($id);

        if (!$saran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $newStatus = $this->request->getPost('status');

        if (!in_array($newStatus, ['Dibaca', 'Diproses', 'Selesai'])) {
            session()->setFlashdata('error', 'Status yang dimasukkan tidak valid.');
            return redirect()->back();
        }

        $this->saranModel->update($id, ['status' => $newStatus]);

        session()->setFlashdata('pesan_update', "Status saran #{$id} berhasil diubah menjadi '{$newStatus}'.");

        return redirect()->to(base_url('saran/detail/' . $id));
    }
}

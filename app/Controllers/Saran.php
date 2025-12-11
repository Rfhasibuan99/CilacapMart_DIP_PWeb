<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaranModel;

class Saran extends BaseController
{
    protected $saranModel;

    public function __construct()
    {
        $this->saranModel = new SaranModel();
        // Memuat helper yang diperlukan untuk form dan otentikasi (Myth/Auth)
        helper(['form', 'url', 'auth']); 
    }

    // A. Tampilan Form Saran (Halaman Public)
    public function index()
    {
        $data = [
            'title' => 'Form Saran & Masukan',
            'validation' => \Config\Services::validation(),
            'kategori_list' => $this->getKategoriOpsi()
        ];
        return view('saran/index', $data);
    }

    // B. Menyimpan Saran dari Pengguna
    public function simpan()
    {
        // 1. Validasi Input
        $rules = [
            'kategori' => 'required',
            'judul_saran' => 'required|max_length[255]',
            'deskripsi' => 'required|max_length[5000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // 2. Tentukan Pengirim (Menggunakan kolom users_id sesuai tabel)
        $usersId = null;
        $username = 'Anonim';
        
        // Cek jika user login dan tidak mencentang anonim
        if (logged_in() && !$this->request->getPost('anonim')) {
            $usersId = user_id();
            $username = user()->username;
        }

        // 3. Simpan ke Database
        $this->saranModel->save([
            'users_id' => $usersId,
            'username' => $username,
            'kategori' => $this->request->getPost('kategori'),
            'judul_saran' => $this->request->getPost('judul_saran'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        session()->setFlashdata('pesan', 'Terima kasih! Saran/Masukan Anda berhasil dikirim.');

        return redirect()->to(base_url('saran'));
    }
    
    // C. Daftar Saran (Hanya Admin)
    // app/Controllers/Saran.php (Metode daftar)

public function daftar()
{
    // Filter akses tetap berlaku
    if (!in_groups('admin')) { 
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $kategoriFilter = $this->request->getVar('kategori');
    $statusFilter = $this->request->getVar('status');

    $builder = $this->saranModel;
    if ($kategoriFilter) {
        $builder = $builder->where('kategori', $kategoriFilter);
    }
    
    $data = [
        'title' => 'Daftar Saran & Masukan',
        'saran_list' => $builder->orderBy('created_at', 'DESC')->findAll(),
        'kategori_aktif' => $kategoriFilter,
        'status_aktif' => $statusFilter,
        'kategori_opsi' => $this->getKategoriOpsi()
    ];

    // PENTING: Mengarahkan ke file saran/detail.php yang kini berisi daftar
    return view('saran/detail', $data); 
}
    
    // D. Detail Saran (Hanya Admin)
    public function detail($id = null)
    {
        if (!in_groups('admin')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $saran = $this->saranModel->find($id);

        if (!$saran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($saran['status'] === 'Baru') {
            $this->saranModel->update($id, ['status' => 'Dibaca']);
            $saran['status'] = 'Dibaca'; 
        }

        return view('saran/admin_detail', ['title' => 'Detail Saran', 'saran' => $saran]);
    }
public function detail_satu($id = null)
{
    if (!in_groups('admin')) { 
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $saran = $this->saranModel->find($id);

    if (!$saran) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    if ($saran['status'] === 'Baru') {
        $this->saranModel->update($id, ['status' => 'Dibaca']);
        $saran['status'] = 'Dibaca'; 
    }

    return view('saran/detail_satu', ['title' => 'Detail Saran Tunggal', 'saran' => $saran]);
}

    private function getKategoriOpsi()
    {
         return [
            'Minuman', 'Makanan', 'Fashion', 'Barang Kerajinan', 'Accessoris', 
            'Bahan Baku', 'Peningkatan Fitur', 'Masalah Teknis', 'Kritik Layanan', 'Lain-lain'
        ];
    }
}
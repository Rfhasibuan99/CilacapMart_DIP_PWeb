<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $BarangModel;

    public function __construct()
    {
        $this->BarangModel = new BarangModel();
    }
    public function index()
    {
        $cari = $this->request->getVar('cari');

        if ($cari) {
            $barang = $this->BarangModel->findBarang($cari)->findAll();
        } else {
            $barang  = $this->BarangModel->getBarang();
        }

        $data = [
            'title' => 'Daftar Barang Toko',
            'barang'   => $barang,
        ];

        return view('barang/index', $data);
    }
  public function detail($idbarang)
{
    $data = [
        'title' => 'Detail Barang',
       'barang' => $this->BarangModel->getBarang($idbarang)
    ];

    return view('barang/detail', $data);
}
    public function tambah()
    {
        $data = [
            'title' => 'Form Tambah Barang',
            'validation' => \Config\Services::validation()
        ];

        return view('barang/tambah', $data);
    }
    public function simpan()
    {
        if (!$this->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'deskripsi' => 'required',
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar wajib diisi',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File harus gambar',
                    'mime_in' => 'Format harus JPG/JPEG/PNG'
                ]
                ],
            'stok' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        ])) {
            return redirect()->to('/barang/tambah')->withInput();
        }

        // upload gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('img', $namaGambar);

        // simpan
        $this->BarangModel->save([
            'nama_barang'   => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'stok'          => $this->request->getVar('stok'),
            'harga_beli'    => $this->request->getVar('harga_beli'),
            'harga_jual'    => $this->request->getVar('harga_jual')
        ]);

        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan');
        return redirect()->to('/barang');
    }
  public function ubah($idbarang)
{
    $BarangModel = new BarangModel();

    $barang = $BarangModel->find($idbarang);

    if (!$barang) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Data barang tidak ditemukan");
    }

    $data = [
        'barang' =>  $BarangModel->find($idbarang),
        'validation' => \Config\Services::validation()
    ];

    return view('barang/ubah', $data);
}
    public function update($idbarang)
    {
        $dataLama = $this->BarangModel->getBarang($idbarang);

        if (!$this->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'deskripsi' => 'required',
            'gambar' => [
                'rules' => 'permit_empty|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]',
            ],
            'stok' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        ])) {
            return redirect()->to('/barang/ubah/' . $idbarang)->withInput();
        }

        // ambil gambar lama
        $gambarLama = $dataLama['gambar'];

        // file baru
        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar->getError() == 4) {
            $namaGambar = $gambarLama; // tidak ganti gambar
        } else {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img', $namaGambar);

            // hapus gambar lama jika ada
            if ($gambarLama && file_exists('img/' . $gambarLama)) {
                unlink('img/' . $gambarLama);
            }
        }

        // simpan update
        $this->BarangModel->save([
            'id_barang'     => $idbarang,
            'nama_barang'   => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'stok'          => $this->request->getVar('stok'),
            'harga_beli'    => $this->request->getVar('harga_beli'),
            'harga_jual'    => $this->request->getVar('harga_jual')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/barang');
    }

    public function hapus($idbarang)
    {
        $barang = $this->BarangModel->getBarang($idbarang);

        // hapus gambar
        if ($barang['gambar'] && file_exists('img/' . $barang['gambar'])) {
            unlink('img/' . $barang['gambar']);
        }

        $this->BarangModel->delete($idbarang);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/barang');
    }
}

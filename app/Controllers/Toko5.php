<?php

namespace App\Controllers;

use App\Models\Toko5Model;

class Toko5 extends BaseController
{
    protected $Toko5Model;

    public function __construct()
    {
        $this->Toko5Model = new Toko5Model();
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $cari = $this->request->getVar('cari');

        if ($cari) {
            $toko5 = $this->Toko5Model->findBarang($cari)->findAll();
        } else {
            $toko5 = $this->Toko5Model->getBarang();
        }

        $data = [
            'title' => 'Daftar Barang Toko',
            'toko5'   => $toko5,
        ];

        return view('toko5/index', $data);
    }

    // ======================
    // FORM TAMBAH
    // ======================
    public function tambah()
    {
        $data = [
            'title' => 'Form Tambah Barang',
            'validation' => \Config\Services::validation()
        ];

        return view('toko5/tambah', $data);
    }

    // ======================
    // SIMPAN DATA BARU
    // ======================
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
            return redirect()->to('/toko5/tambah')->withInput();
        }

        // upload gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('img', $namaGambar);

        // simpan
        $this->Toko5Model->save([
            'nama_barang'   => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'stok'          => $this->request->getVar('stok'),
            'harga_beli'    => $this->request->getVar('harga_beli'),
            'harga_jual'    => $this->request->getVar('harga_jual')
        ]);

        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan');
        return redirect()->to('/toko5');
    }

    // ======================
    // FORM EDIT
    // ======================
    public function ubah($idbarang)
    {
        $data = [
            'title' => 'Form Ubah Barang',
            'validation' => \Config\Services::validation(),
            'toko5' => $this->Toko5Model->getBarang($idbarang)
        ];

        return view('toko5/ubah', $data);
    }

    // ======================
    // UPDATE DATA
    // ======================
    public function update($idbarang)
    {
        $dataLama = $this->Toko5Model->getBarang($idbarang);

        if (!$this->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'deskripsi' => 'required',
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]',
            ],
            'stok' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric'
        ])) {
            return redirect()->to('/toko5/ubah/' . $idbarang)->withInput();
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
        $this->Toko5Model->save([
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
        return redirect()->to('/toko5');
    }

    // ======================
    // HAPUS DATA
    // ======================
    public function hapus($idbarang)
    {
        $barang = $this->Toko5Model->getBarang($idbarang);

        // hapus gambar
        if ($barang['gambar'] && file_exists('img/' . $barang['gambar'])) {
            unlink('img/' . $barang['gambar']);
        }

        $this->Toko5Model->delete($idbarang);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/toko5');
    }
}

<?php

namespace App\Controllers;

use App\Models\Toko3Model;

class Toko3 extends BaseController
{
    protected $Toko3Model;

    public function __construct()
    {
        $this->Toko3Model = new Toko3Model();
    }

    public function index()
    {
        $cari = $this->request->getVar('cari');

        if ($cari) {
            $toko3 = $this->Toko3Model->findBarang($cari)->findAll();
        } else {
            $toko3 = $this->Toko3Model->getBarang();
        }

        return view('toko3/index', [
            'title' => 'Daftar Barang toko3',
            'toko3' => $toko3
        ]);
    }

    public function tambah()
    {
        return view('toko3/tambah', [
            'title' => 'Form Tambah Barang',
            'validation' => \Config\Services::validation()
        ]);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nama_barang'   => 'required',
            'jenis_barang' => 'required',
            'harga_barang'  => 'required|numeric',
            'deskripsi'     => 'required',
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
            ]
        ])) {
            return redirect()->to('/toko3/tambah')->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('img', $namaGambar);

        $this->Toko3Model->save([
            'nama_barang' => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'harga_barang' => $this->request->getVar('harga_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan');
        return redirect()->to('/toko3');
    }

    public function ubah($id)
    {
        return view('toko3/ubah', [
            'title' => 'Form Ubah Barang',
            'validation' => \Config\Services::validation(),
            'toko3' => $this->Toko3Model->getBarang($id)
        ]);
    }

    public function update($id)
    {
        $dataLama = $this->Toko3Model->getBarang($id);

        if (!$this->validate([
            'nama_barang'   => 'required',
            'jenis_barang' => 'required',
            'harga_barang'  => 'required|numeric',
            'deskripsi'     => 'required',
            'gambar'        => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]'
        ])) {
            return redirect()->to('/toko3/ubah/' . $id)->withInput();
        }

        $file = $this->request->getFile('gambar');
        $namaGambar = ($file->getError() == 4)
            ? $dataLama['gambar']
            : $file->getRandomName();

        if ($file->getError() != 4) {
            $file->move('img', $namaGambar);
            if ($dataLama['gambar'] && file_exists('img/' . $dataLama['gambar'])) {
                unlink('img/' . $dataLama['gambar']);
            }
        }

        $this->Toko3Model->save([
            'id_barang' => $id,
            'nama_barang' => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'harga_barang' => $this->request->getVar('harga_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/toko3');
    }

    public function hapus($id)
    {
        $data = $this->Toko3Model->getBarang($id);

        if ($data['gambar'] && file_exists('img/' . $data['gambar'])) {
            unlink('img/' . $data['gambar']);
        }

        $this->Toko3Model->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/toko3');
    }
}

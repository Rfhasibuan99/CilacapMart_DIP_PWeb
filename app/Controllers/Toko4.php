<?php

namespace App\Controllers;

use App\Models\Toko4Model;

class Toko4 extends BaseController
{
    protected $Toko4Model;

    public function __construct()
    {
        $this->Toko4Model = new Toko4Model();
    }

    public function index()
    {
        $cari = $this->request->getVar('cari');

        if ($cari) {
            $toko4 = $this->Toko4Model->findBarang($cari)->findAll();
        } else {
            $toko4 = $this->Toko4Model->getBarang();
        }

        return view('toko4/index', [
            'title' => 'Daftar Barang toko4',
            'toko4' => $toko4
        ]);
    }

    public function tambah()
    {
        return view('toko4/tambah', [
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
            return redirect()->to('/toko4/tambah')->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('img', $namaGambar);

        $this->Toko4Model->save([
            'nama_barang' => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'harga_barang' => $this->request->getVar('harga_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan');
        return redirect()->to('/toko4');
    }

    public function ubah($id)
    {
        return view('toko4/ubah', [
            'title' => 'Form Ubah Barang',
            'validation' => \Config\Services::validation(),
            'toko4' => $this->Toko4Model->getBarang($id)
        ]);
    }

    public function update($id)
    {
        $dataLama = $this->Toko4Model->getBarang($id);

        if (!$this->validate([
            'nama_barang'   => 'required',
            'jenis_barang' => 'required',
            'harga_barang'  => 'required|numeric',
            'deskripsi'     => 'required',
            'gambar'        => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]'
        ])) {
            return redirect()->to('/toko4/ubah/' . $id)->withInput();
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

        $this->Toko4Model->save([
            'id_barang' => $id,
            'nama_barang' => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'harga_barang' => $this->request->getVar('harga_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/toko4');
    }

    public function hapus($id)
    {
        $data = $this->Toko4Model->getBarang($id);

        if ($data['gambar'] && file_exists('img/' . $data['gambar'])) {
            unlink('img/' . $data['gambar']);
        }

        $this->Toko4Model->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/toko4');
    }
}

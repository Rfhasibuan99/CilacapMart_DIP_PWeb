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

    public function index()
    {
        $cari = $this->request->getVar('cari');

        if ($cari) {
            $rhanif = $this->Toko5Model->findBarang($cari)->findAll();
        } else {
            $rhanif = $this->Toko5Model->getBarang();
        }

        return view('rhanif/index', [
            'title' => 'Daftar Barang Toko',
            'rhanif' => $rhanif
        ]);
    }

    public function tambah()
    {
        return view('rhanif/tambah', [
            'title' => 'Form Tambah Barang',
            'validation' => \Config\Services::validation()
        ]);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'harga_barang' => 'required|numeric',
            'deskripsi' => 'required',
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
            ]
        ])) {
            return redirect()->to('/rhanif/tambah')->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('img', $namaGambar);

        $this->Toko5Model->save([
            'nama_barang' => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'harga_barang' => $this->request->getVar('harga_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan');
        return redirect()->to('/rhanif');
    }

    public function ubah($id)
    {
        return view('rhanif/ubah', [
            'title' => 'Form Ubah Barang',
            'validation' => \Config\Services::validation(),
            'rhanif' => $this->Toko5Model->getBarang($id)
        ]);
    }

    public function update($id)
    {
        $dataLama = $this->Toko5Model->getBarang($id);

        if (!$this->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'harga_barang' => 'required|numeric',
            'deskripsi' => 'required',
            'gambar' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]'
        ])) {
            return redirect()->to('/rhanif/ubah/' . $id)->withInput();
        }

        $file = $this->request->getFile('gambar');
        $namaGambar = ($file->getError() == 4) ? $dataLama['gambar'] : $file->getRandomName();

        if ($file->getError() != 4) {
            $file->move('img', $namaGambar);
            if ($dataLama['gambar'] && file_exists('img/' . $dataLama['gambar'])) {
                unlink('img/' . $dataLama['gambar']);
            }
        }

        $this->Toko5Model->save([
            'id_barang' => $id,
            'nama_barang' => $this->request->getVar('nama_barang'),
            'jenis_barang' => $this->request->getVar('jenis_barang'),
            'harga_barang' => $this->request->getVar('harga_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/rhanif');
    }

    public function hapus($id)
    {
        $data = $this->Toko5Model->getBarang($id);

        if ($data['gambar'] && file_exists('img/' . $data['gambar'])) {
            unlink('img/' . $data['gambar']);
        }

        $this->Toko5Model->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/rhanif');
    }
}

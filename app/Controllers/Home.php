<?php

namespace App\Controllers;

use App\Models\ShopModel;

class Home extends BaseController
{
    protected $shopModel;
    protected $Toko1Model;
    protected $Toko2Model;
    protected $Toko3Model;
    protected $Toko4Model;
    protected $Toko5Model;

    public function __construct()
    {
        $this->shopModel = new ShopModel();
    }

    public function index(): string
    {
        $cari = $this->request->getVar('cari');
        if ($cari) {
            $shop = $this->shopModel->findShop($cari)->findAll();
        } else {
            $shop = $this->shopModel->getShop();
        }
       $data = [
    'title' => 'Daftar Toko',
    'shop'  => $shop,
    'toko' => [
        ['nama_toko'=> 'Jajan koe', 'link' => '/toko1', 'gambar' => '/img/jajankoe.jpg'],
        ['nama_toko'=> 'Cemiland', 'link' => '/toko2', 'gambar' => '/img/cemiland.jpg'],
        ['nama_toko'=> 'Grek', 'link' => '/toko3', 'gambar' => '/img/grek.jpg'],
        ['nama_toko'=> 'Handcraft', 'link' => '/toko4', 'gambar' => '/img/handcraft.jpg'],
        ['nama_toko'=> 'WS Jaya Cilacap', 'link' => '/toko5', 'gambar' => '/img/wsjaya.jpg'],
    ]
];


        return view('layout/home', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Form Tambah Toko',
            'validation' => \Config\Services::validation()
        ];

        return view('layout/tambah', $data);
    }
    public function simpan()
    {
        if (!$this->validate([
            'nama_toko' => 'required',
            'deskripsi' => 'required',
            'nomor' => 'required',
            'jam' => 'required',
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Format gambar tidak sesuai'
                ]
            ],
        ])) {
            return redirect()->to('/layout/tambah')->withInput();
        }

        //ambil gambar
        $fileGambar = $this->request->getFile('gambar');
        //pindahkan ke folder img
        $fileGambar->move('img');
        //ambil nama file
        $namaGambar = $fileGambar->getName();

        $this->shopModel->save([
            'nama_toko' => $this->request->getVar('nama_toko'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'nomor' => $this->request->getVar('nomor'),
            'jam' => $this->request->getVar('jam'),
            'gambar' => $namaGambar,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/layout/home');
    }
    public function ubah($idshop)
    {
        $data = [
            'title' => 'Form Ubah Toko',
            'validation' => \Config\Services::validation(),
            'shop' => $this->shopModel->getShop($idshop)
        ];

        return view('layout/ubah', $data);
    }
    public function update($idshop)
    {
        if (!$this->validate([
            'nama_toko' => 'required',
            'deskripsi' => 'required',
            'nomor' => 'required',
            'jam' => 'required',
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Format gambar tidak sesuai'
                ]
            ],
        ])) {
            return redirect()->to('/layout/ubah/' . $idshop)->withInput();
        }

        //ambil gambar
        $fileGambar = $this->request->getFile('gambar');

        //cek gambar, apakah tetap gambar lama
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            //pindahkan ke folder img
            $fileGambar->move('img');
            //ambil nama file
            $namaGambar = $fileGambar->getName();
        }

        $this->shopModel->save([
            'id_toko' => $idshop,
            'nama_toko' => $this->request->getVar('nama_toko'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'nomor' => $this->request->getVar('nomor'),
            'jam' => $this->request->getVar('jam'),
            'gambar' => $namaGambar,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/layout/home');
    }
    public function hapus($idshop)
    {
        //cari gambar berdasarkan id
        $shop = $this->shopModel->find($idshop);

        //hapus gambar
        if ($shop['gambar'] != '') {
            unlink('img/' . $shop['gambar']);
        }

        $this->shopModel->hapus($idshop);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');

        return redirect()->to('/layout/home');
    }
}

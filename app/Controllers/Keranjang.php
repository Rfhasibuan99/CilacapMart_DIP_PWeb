<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\Toko1Model;
use App\Models\Toko2Model;
use App\Models\Toko3Model;
use App\Models\Toko4Model;
use App\Models\Toko5Model;

class Keranjang extends BaseController
{
    protected $keranjangModel;
    protected $tokoModels = [];

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        $this->tokoModels[1] = new Toko1Model();
        $this->tokoModels[2] = new Toko2Model();
        $this->tokoModels[3] = new Toko3Model();
        $this->tokoModels[4] = new Toko4Model();
        $this->tokoModels[5] = new Toko5Model();
    }

    public function index()
    {
        $idUser = session()->get('id');
        if (!$idUser) {
            return redirect()->to('/login');
        }

        $items = $this->keranjangModel
            ->where('id_user', $idUser)
            ->findAll();

        // enrich items with barang details from the appropriate toko model
        foreach ($items as &$item) {
            $tokoId = isset($item['id_toko']) ? (int)$item['id_toko'] : null;

            if ($tokoId && isset($this->tokoModels[$tokoId])) {
                $barang = $this->tokoModels[$tokoId]->where('id_barang', $item['id_barang'])->first();
            } else {
                // jika id_toko tidak tersedia, cari di semua toko
                $barang = null;
                foreach ($this->tokoModels as $tid => $model) {
                    $found = $model->where('id_barang', $item['id_barang'])->first();
                    if ($found) {
                        $barang = $found;
                        $item['id_toko'] = $tid;
                        break;
                    }
                }
            }

            if ($barang) {
                $item['nama_barang'] = $barang['nama_barang'] ?? ($barang['nama'] ?? null);
                $item['harga_barang'] = $barang['harga_barang'] ?? ($barang['harga'] ?? null);
                $item['gambar'] = $barang['gambar'] ?? null;
            } else {
                $item['nama_barang'] = null;
                $item['harga_barang'] = null;
                $item['gambar'] = null;
            }
        }
        unset($item);

        $data = [
            'keranjang' => $items
        ];

        return view('keranjang/index', $data);
    }

    public function tambah()
    {
        $idUser = session()->get('id_user');
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $idBarang = (int) $this->request->getPost('id_barang');
        $jumlah = (int) $this->request->getPost('jumlah');
        $toko = $this->request->getPost('toko') !== null ? (int)$this->request->getPost('toko') : null;

        if ($idBarang <= 0 || $jumlah <= 0) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }

        // jika toko disediakan, validasi
        if ($toko !== null) {
            if (!isset($this->tokoModels[$toko])) {
                return redirect()->back()->with('error', 'Toko tidak valid');
            }
            // pastikan barang ada di toko tersebut
            $found = $this->tokoModels[$toko]->where('id_barang', $idBarang)->first();
            if (!$found) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan di toko yang dipilih');
            }
            $tokoIdToUse = $toko;
        } else {
            // cari barang di semua toko dan ambil toko pertama yang menemukan
            $tokoIdToUse = null;
            foreach ($this->tokoModels as $tid => $model) {
                if ($model->where('id_barang', $idBarang)->first()) {
                    $tokoIdToUse = $tid;
                    break;
                }
            }
            if (!$tokoIdToUse) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan di semua toko');
            }
        }

        $cek = $this->keranjangModel
            ->where('id_barang', $idBarang)
            ->where('id_user', $idUser)
            ->first();

        if ($cek) {
            $this->keranjangModel->update($cek['id_keranjang'], [
                'jumlah' => $cek['jumlah'] + $jumlah
            ]);
        } else {
            $this->keranjangModel->save([
                'id_barang' => $idBarang,
                'id_user'   => $idUser,
                'id_toko'   => $tokoIdToUse,
                'jumlah'    => $jumlah
            ]);
        }

        return redirect()->to('/keranjang')->with('pesan', 'Berhasil ditambahkan ke keranjang');
    }

    public function hapus($id_keranjang)
    {
        $idUser = session()->get('id');
        if (!$idUser) {
            return redirect()->to('/login');
        }

        $item = $this->keranjangModel
            ->where('id_keranjang', $id_keranjang)
            ->where('id_user', $idUser)
            ->first();

        if ($item) {
            $this->keranjangModel->delete($id_keranjang);
            return redirect()->to('/keranjang')->with('pesan', 'Item keranjang berhasil dihapus');
        }

        return redirect()->to('/keranjang')->with('error', 'Item tidak ditemukan atau bukan milik Anda');
    }
}

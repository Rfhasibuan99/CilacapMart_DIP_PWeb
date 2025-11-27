<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\Toko1Model;
use App\Models\Toko2Model;
use App\Models\Toko3Model;
use App\Models\Toko4Model;
use App\Models\Toko5Model;
use App\Models\ShopModel; // jika ada

class Keranjang extends BaseController
{
    protected $keranjangModel;
    protected $tokoModels = [];

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        // inisialisasi model toko (sesuaikan nama file model-mu)
        $this->tokoModels[1] = new Toko1Model();
        $this->tokoModels[2] = new Toko2Model();
        $this->tokoModels[3] = new Toko3Model();
        $this->tokoModels[4] = new Toko4Model();
        $this->tokoModels[5] = new Toko5Model();
        // jika ada tabel shop:
        if (class_exists('\App\Models\ShopModel')) {
            $this->tokoModels['shop'] = new \App\Models\ShopModel();
        }
    }

    protected function getUserId()
    {
        // pakai Myth/Auth helper user() bila tersedia, fallback session('id')
        if (function_exists('user')) {
            $u = user(); // entity or null
            return $u ? $u->id : null;
        }
        return session()->get('id') ?? null;
    }

    public function index()
    {
        $idUser = $this->getUserId();
        if (!$idUser) {
            return redirect()->to('/login');
        }

        $items = $this->keranjangModel->where('id_user', $idUser)->findAll();

        // enrich items with nama/harga/gambar dari toko yang sesuai
        foreach ($items as &$item) {
            $barang = null;
            // jika id_toko diberikan cari di toko tersebut
            if (!empty($item['id_toko']) && isset($this->tokoModels[$item['id_toko']])) {
                $barang = $this->tokoModels[$item['id_toko']]->find($item['id_barang']);
            } else {
                // jika tidak ada id_toko cari di semua toko
                foreach ($this->tokoModels as $tid => $model) {
                    $found = $model->find($item['id_barang']);
                    if ($found) {
                        $barang = $found;
                        $item['id_toko'] = $tid;
                        break;
                    }
                }
            }

            if ($barang) {
                $item['nama_barang']  = $barang['nama_barang'] ?? ($barang['nama'] ?? null);
                $item['harga_barang'] = $barang['harga_barang'] ?? ($barang['harga'] ?? null);
                $item['gambar']       = $barang['gambar'] ?? null;
            } else {
                $item['nama_barang']  = 'Produk tidak ditemukan';
                $item['harga_barang'] = 0;
                $item['gambar']       = null;
            }
        }
        unset($item);

        // group by toko (untuk tampilan checkout per toko opsional)
        $grouped = [];
        foreach ($items as $it) {
            $tid = $it['id_toko'] ?? 'unknown';
            $grouped[$tid][] = $it;
        }

        return view('keranjang/index', [
            'keranjang' => $items,
            'grouped'   => $grouped
        ]);
    }

    public function tambah()
    {
        $idUser = $this->getUserId();
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $idBarang = (int) $this->request->getPost('id_barang');
        $jumlah   = (int) $this->request->getPost('jumlah') ?: 1;
        $toko     = $this->request->getPost('toko') !== null ? $this->request->getPost('toko') : null;

        if ($idBarang <= 0 || $jumlah <= 0) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }

        // tentukan toko yang valid dan pastikan barang ada
        $tokoIdToUse = null;
        if ($toko !== null && isset($this->tokoModels[$toko])) {
            $found = $this->tokoModels[$toko]->find($idBarang);
            if (!$found) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan di toko yang dipilih');
            }
            $tokoIdToUse = $toko;
        } else {
            // cari di semua toko
            foreach ($this->tokoModels as $tid => $model) {
                $found = $model->find($idBarang);
                if ($found) {
                    $tokoIdToUse = $tid;
                    break;
                }
            }
            if (!$tokoIdToUse) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan');
            }
        }

        // cek apakah sudah ada di keranjang user untuk barang & toko yang sama
        $cek = $this->keranjangModel
            ->where('id_user', $idUser)
            ->where('id_barang', $idBarang)
            ->where('id_toko', $tokoIdToUse)
            ->first();

        if ($cek) {
            $this->keranjangModel->update($cek['id_keranjang'], [
                'jumlah' => $cek['jumlah'] + $jumlah
            ]);
        } else {
            $this->keranjangModel->save([
                'id_user'   => $idUser,
                'id_barang' => $idBarang,
                'id_toko'   => $tokoIdToUse,
                'jumlah'    => $jumlah
            ]);
        }

        return redirect()->to('/keranjang')->with('pesan', 'Berhasil ditambahkan ke keranjang');
    }

    public function hapus($id_keranjang)
    {
        $idUser = $this->getUserId();
        if (!$idUser) return redirect()->to('/login');

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

    // simpel checkout: grup per toko -> redirect ke halaman konfirmasi
    public function checkout()
    {
        $idUser = $this->getUserId();
        if (!$idUser) return redirect()->to('/login');

        $items = $this->keranjangModel->where('id_user', $idUser)->findAll();
        if (!$items) return redirect()->to('/keranjang')->with('error', 'Keranjang kosong');

        // implementasi checkout lengkap (alamat, ongkir, pembayaran) disini
        // untuk contoh sederhana kita hapus semua item dan redirect sukses

        foreach ($items as $it) {
            $this->keranjangModel->delete($it['id_keranjang']);
        }

        return redirect()->to('/keranjang')->with('pesan', 'Checkout berhasil (demo). Keranjang dikosongkan.');
    }
}

<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\BarangModel;
use App\Models\PesananModel;
use App\Models\DetailPesananModel;

class Checkout extends BaseController
{
    public function index()
    {
        $idUser = session()->get('id');
        $keranjangModel = new KeranjangModel();

        // ambil keranjang lengkap
        $items = $keranjangModel->getKeranjangWithBarang($idUser);

        // hitung total
        $total = 0;
        foreach ($items as $item) {
            $total += $item['harga_jual'] * $item['jumlah'];
        }

        return view('checkout/index', [
            'keranjang' => $items,
            'total' => $total
        ]);
    }

    public function proses()
    {
        $idUser = session()->get('id');

        $keranjangModel = new KeranjangModel();
        $barangModel = new BarangModel();
        $pesananModel = new PesananModel();
        $detailModel = new DetailPesananModel();

        $items = $keranjangModel->getKeranjangWithBarang($idUser);

        if (!$items) {
            return redirect()->to('/checkout')->with('error', 'Keranjang kosong');
        }

        // total belanja
        $total = 0;
        foreach ($items as $item) {
            $total += $item['harga_jual'] * $item['jumlah'];
        }

        // simpan pesanan
        $kode = "ORD" . time();

        $pesananModel->insert([
            'id_user' => $idUser,
            'kode_pesanan' => $kode,
            'total_harga' => $total,
            'status' => 'pending'
        ]);

        $idPesanan = $pesananModel->insertID();

        // simpan detail pesanan
        foreach ($items as $item) {
            $detailModel->insert([
                'id_pesanan' => $idPesanan,
                'id_barang' => $item['id_barang'],
                'harga' => $item['harga_jual'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['harga_jual'] * $item['jumlah']
            ]);
        }

        // kosongkan keranjang
        $keranjangModel->where('id_user', $idUser)->delete();

        return redirect()->to('/pesanan/detail/' . $idPesanan);
    }
}

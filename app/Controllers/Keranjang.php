<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\BarangModel; 
use CodeIgniter\Controller; 

class Keranjang extends Controller
{
    protected $keranjangModel;
    protected $barangModel;
    protected $user_id = 1; 

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        $this->barangModel = new BarangModel(); 
    }

    protected function prepareKeranjangData(array $keranjangItems): array
    {
        $totalKeranjang = 0;
        $cleanKeranjang = []; 
        
        foreach($keranjangItems as $item) {
            
            if (!is_array($item)) {
                log_message('error', 'Corrupted item found in keranjang data. Item skipped.');
                continue; 
            }
            
            $harga_jual = (float)($item['harga_jual'] ?? 0);
            $jumlah = (int)($item['jumlah'] ?? 0);
            $subtotal = $harga_jual * $jumlah;
            
            $cleanItem = [
                'id_keranjang' => $item['id_keranjang'] ?? null,
                'id_user' => $item['id_user'] ?? $this->user_id,
                'id_barang' => $item['id_barang'] ?? null,
                'nama_barang' => $item['nama_barang'] ?? 'Nama Barang Hilang', 
                'gambar' => $item['gambar'] ?? '', 
                'harga_jual' => $harga_jual, 
                'jumlah' => $jumlah,
                'subtotal' => $subtotal 
            ];

            $totalKeranjang += $subtotal;
            $cleanKeranjang[] = $cleanItem;
        }
        
        return [
            'items' => $cleanKeranjang,
            'total' => $totalKeranjang
        ];
    }

    public function index()
    {
        $keranjangItems = $this->keranjangModel->getItemsKeranjang($this->user_id);
        $preparedData = $this->prepareKeranjangData($keranjangItems);
        
        $data = [
            'title' => 'Keranjang Belanja',
            'keranjang' => $preparedData['items'],
            'total' => $preparedData['total']
        ];
        
        return view('keranjang/index', $data); 
    }

    public function tambah()
    {
        $id_barang = $this->request->getPost('id_barang');
        $jumlah = (int)$this->request->getPost('jumlah') ?? 1;

        $barang = $this->barangModel->getBarang($id_barang);

        if (!$barang) { 
             return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }
        
        if ($barang['stok'] < $jumlah) {
             return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }
        
        $existingItem = $this->keranjangModel
            ->where('id_user', $this->user_id)
            ->where('id_barang', $id_barang)
            ->first();

        if ($existingItem) {
            $newJumlah = $existingItem['jumlah'] + $jumlah;
            
            if ($barang['stok'] < $newJumlah) {
                return redirect()->back()->with('error', 'Jumlah total melebihi stok yang tersedia.');
            }
            
            $this->keranjangModel->update($existingItem['id_keranjang'], [
                'jumlah' => $newJumlah
            ]);
        } else {
            $this->keranjangModel->insert([
                'id_user' => $this->user_id,
                'id_barang' => $id_barang,
                'nama_barang' => $barang['nama_barang'],
                'harga_jual' => $barang['harga_jual'], 
                'gambar' => $barang['gambar'] ?? '', 
                'jumlah' => $jumlah
            ]);
        }
        
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }
    
    public function hapus($id_keranjang)
    {
        $this->keranjangModel->delete($id_keranjang);
        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }
}
<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\BarangModel; 
use CodeIgniter\Controller; 

class Keranjang extends Controller
{
    protected $keranjangModel;
    protected $barangModel;
    // TODO: Ganti 1 dengan id_user nyata dari session/auth
    protected $user_id = 1; 

    public function __construct()
    {
        // Memuat Model
        $this->keranjangModel = new KeranjangModel();
        // Asumsi BarangModel sudah ada dan menggunakan 'harga_jual'
        $this->barangModel = new BarangModel(); 
    }

    /**
     * Menyiapkan data keranjang untuk View (keranjang/index atau checkout/index).
     * Ini adalah logika inti yang memastikan data keranjang aman.
     * @param array $keranjangItems 
     * @return array
     */
    protected function prepareKeranjangData(array $keranjangItems): array
    {
        $totalKeranjang = 0;
        $cleanKeranjang = []; // Array baru untuk menampung data yang sudah di-sanitize
        
        foreach($keranjangItems as $item) {
            
            // Safety check: Skip if item is not a valid array structure
            if (!is_array($item)) {
                log_message('error', 'Corrupted item found in keranjang data. Item skipped.');
                continue; 
            }
            
            // FIX: Menggunakan Null Coalescing untuk mendapatkan nilai dengan default 0 atau string kosong
            $harga_jual = (int)($item['harga_jual'] ?? 0);
            $jumlah = (int)($item['jumlah'] ?? 0);
            $subtotal = $harga_jual * $jumlah;
            
            // FIX BARU: Membangun array item secara eksplisit untuk menjamin semua key ada
            $cleanItem = [
                'id_keranjang' => $item['id_keranjang'] ?? null,
                'id_user' => $item['id_user'] ?? $this->user_id,
                'id_barang' => $item['id_barang'] ?? null,
                'nama_barang' => $item['nama_barang'] ?? 'Nama Barang Hilang', 
                'gambar' => $item['gambar'] ?? '', 
                'harga_jual' => $harga_jual, // Key ini adalah yang BENAR
                'jumlah' => $jumlah,
                'subtotal' => $subtotal // Key ini dijamin ada
            ];

            $totalKeranjang += $subtotal;
            $cleanKeranjang[] = $cleanItem;
        }
        
        return [
            'items' => $cleanKeranjang,
            'total' => $totalKeranjang
        ];
    }

    /**
     * Menampilkan halaman keranjang belanja dengan daftar item dan total.
     */
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

    /**
     * Menambahkan item ke keranjang atau memperbarui jumlahnya.
     */
    public function tambah()
    {
        $id_barang = $this->request->getPost('id_barang');
        $jumlah = (int)$this->request->getPost('jumlah') ?? 1;

        $barang = $this->barangModel->getBarang($id_barang);

        if (!$barang) { 
             return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }
        
        // Validasi stok awal
        if ($barang['stok'] < $jumlah) {
             return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }
        
        $existingItem = $this->keranjangModel
            ->where('id_user', $this->user_id)
            ->where('id_barang', $id_barang)
            ->first();

        if ($existingItem) {
            // Logika UPDATE: Tambah jumlah jika sudah ada
            $newJumlah = $existingItem['jumlah'] + $jumlah;
            
            // Validasi stok setelah penambahan
            if ($barang['stok'] < $newJumlah) {
                return redirect()->back()->with('error', 'Jumlah total melebihi stok yang tersedia.');
            }
            
            $this->keranjangModel->update($existingItem['id_keranjang'], [
                'jumlah' => $newJumlah
            ]);
        } else {
            // Logika INSERT: Masukkan item baru
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
    
    /**
     * Menghapus satu item dari keranjang berdasarkan ID keranjang.
     * @param int $id_keranjang ID item keranjang.
     */
    public function hapus($id_keranjang)
    {
        $this->keranjangModel->delete($id_keranjang);
        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }
    
    /**
     * Menampilkan halaman checkout.
     */
    public function checkout()
    {
        $keranjangItems = $this->keranjangModel->getItemsKeranjang($this->user_id);
        $preparedData = $this->prepareKeranjangData($keranjangItems);
        
        // TODO: Anda harus menambahkan logic pengambilan data Alamat, Kurir, dll. di sini.

        $data = [
            'title' => 'Proses Checkout',
            'keranjang' => $preparedData['items'],
            'total' => $preparedData['total']
        ];
        
        return view('checkout/index', $data); 
    }
}
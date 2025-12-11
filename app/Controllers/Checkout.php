<?php 
namespace App\Controllers;

use App\Models\AlamatModel; 
// Import model lain yang Anda butuhkan
use CodeIgniter\Controller; // Gunakan Controller atau BaseController jika Anda memilikinya

class Checkout extends Controller
{
    // Pastikan session/auth sudah dimuat untuk mendapatkan ID user
    protected $session;
    
    public function __construct()
    {
        // Contoh: Memuat session
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // 1. Validasi Method dan Data
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to(base_url('keranjang'))->with('error', 'Silahkan pilih item yang akan di checkout terlebih dahulu.');
        }

        $selectedItemsJson = $this->request->getPost('selected_items_json');
        $calculatedTotalPrice = (float)$this->request->getPost('calculated_total_price');
        $keranjang = json_decode($selectedItemsJson, true);

        if (empty($keranjang)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }

        // 2. Siapkan Data Statis/User
        // Ganti dengan logic mendapatkan ID user dari session
        $idUser = $this->session->get('id_user') ?? 1; 
        
        $alamatModel = new AlamatModel(); 
        $alamatUser = $alamatModel->findDefaultAlamat($idUser); 

        if (empty($alamatUser)) {
             $alamatUser = [
                'penerima' => 'Nama Penerima Default',
                'telp' => '0812xxxxxxx',
                'alamat_lengkap' => 'Alamat lengkap default'
             ];
        }

        // 3. Hitung Rincian Final
        $subtotalProduk = $calculatedTotalPrice; 
        $diskon = 0;
        $ongkir = 20000;
        $totalFinal = $subtotalProduk - $diskon + $ongkir;
        
        // 4. Kirim Data ke View
        $data = [
            'title' => 'Checkout Pesanan',
            'keranjang' => $keranjang,
            'alamat_user' => $alamatUser,
            'subtotal_produk' => $subtotalProduk,
            'diskon' => $diskon,
            'ongkir' => $ongkir,
            'total_final' => $totalFinal,
            'sumber_pesanan' => 'keranjang_terpilih',
        ];

        // Memuat View yang benar
        return view('checkout/index', $data); 
    }
    
    // Tambahkan method proses() di sini
    public function proses() 
    {
        // ... Logic untuk menyimpan pesanan ke database ...
    }
}
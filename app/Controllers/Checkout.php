<?php 
namespace App\Controllers;

use App\Models\AlamatModel; 
use CodeIgniter\Controller; 
class Checkout extends Controller 
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to(base_url('keranjang'))->with('error', 'Silahkan pilih item yang akan di checkout terlebih dahulu.');
        }

        $selectedItemsJson = $this->request->getPost('selected_items_json');
        $calculatedTotalPrice = (float)$this->request->getPost('calculated_total_price');
        $keranjang = json_decode($selectedItemsJson, true);

        if (empty($keranjang)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }

        $idUser = $this->session->get('id_user') ?? 1; 
        $alamatUser = $alamatModel->findDefaultAlamat($idUser); 

        if (empty($alamatUser)) {
             $alamatUser = [
                'penerima' => 'Nama Penerima Default',
                'telp' => '0812xxxxxxx',
                'alamat_lengkap' => 'Alamat lengkap default'
             ];
        }
        $subtotalProduk = $calculatedTotalPrice; 
        $diskon = 0;
        $ongkir = 20000;
        $totalFinal = $subtotalProduk - $diskon + $ongkir;
        
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

        return view('checkout/index', $data); 
    }
    
    public function proses() 
    {
    }
}
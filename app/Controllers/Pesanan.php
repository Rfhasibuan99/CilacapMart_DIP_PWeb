<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel; 
use App\Models\KeranjangModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pesanan extends Controller
{
    protected $pesananModel;
    protected $detailPesananModel;
    protected $keranjangModel;
    protected $user_id; 
    protected $session;
    protected $request;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->detailPesananModel = new DetailPesananModel();
        $this->keranjangModel = new KeranjangModel();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->user_id = user_id() ?? 1; 
    }

    public function index()
    {
        $pesanan = $this->pesananModel->getPesananByUser($this->user_id);

        foreach ($pesanan as &$order) {
            $detail = $this->detailPesananModel->getDetailByPesananId($order['id_pesanan']);
            $order['item_count'] = count($detail);
            $order['gambar'] = !empty($detail) ? ($detail[0]['gambar'] ?? 'default.jpg') : 'default.jpg';
        }

        $data = [
            'title' => 'Daftar Riwayat Pesanan Saya',
            'pesanan' => $pesanan,
        ];

        return view('pesanan/index', $data);
    }

    public function detail($identifier)
    {
        if (is_numeric($identifier)) {
            $pesanan = $this->pesananModel->find($identifier);
        } else {
            $pesanan = $this->pesananModel->where('kode_pesanan', $identifier)->first();
        }

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        $detail = $this->detailPesananModel->getDetailByPesananId($pesanan['id_pesanan']);

        $alamat = [
            'penerima' => $pesanan['penerima_pesanan'],
            'telp' => $pesanan['telp_pesanan'],
            'alamat_lengkap' => $pesanan['alamat_lengkap_pesanan'],
        ];

        $data = [
            'title' => 'Detail Pesanan',
            'pesanan' => $pesanan,
            'detail' => $detail,
            'alamat' => $alamat,
            'metode_bayar' => $pesanan['metode_pembayaran'],
            'metode_kirim' => $pesanan['metode_pengiriman'],
        ];

        return view('pesanan/detail', $data);
    }

    public function prepare_review()
    {
        if (!$this->request->is('post')) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Silahkan pilih item yang akan di checkout terlebih dahulu.');
        }

        $selectedItemsJson = $this->request->getPost('selected_items_json');
        $calculatedTotalPrice = (float)$this->request->getPost('calculated_total_price');
        $keranjangItems = json_decode($selectedItemsJson, true);

        if (empty($keranjangItems)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }
        
        $checkoutData = [
            'keranjangItems' => $keranjangItems,
            'calculatedTotalPrice' => $calculatedTotalPrice,
            'isCheckout' => true,
        ];
        $this->session->set('temp_checkout_data', $checkoutData); 
        
        return redirect()->to(base_url('pesanan/input_alamat')); 
    }

    public function buy_now_start()
    {
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Metode tidak diizinkan.');
        }

        $id_barang = $this->request->getPost('id_barang');
        $nama_barang = $this->request->getPost('nama_barang');
        $harga_jual = (float)$this->request->getPost('harga_jual');
        $jumlah = (int)$this->request->getPost('jumlah');
        $gambar = $this->request->getPost('gambar');

        if (empty($id_barang) || $jumlah <= 0) {
            return redirect()->back()->with('error', 'Data barang tidak lengkap atau jumlah tidak valid.');
        }

        $subtotal = $harga_jual * $jumlah;
        $singleItem = [
            [
                'id_barang' => $id_barang,
                'nama_barang' => $nama_barang,
                'harga_jual' => $harga_jual,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'gambar' => $gambar 
            ]
        ];
        $calculatedTotalPrice = $subtotal;

        $checkoutData = [
            'keranjangItems' => $singleItem,
            'calculatedTotalPrice' => $calculatedTotalPrice,
            'isCheckout' => false,
        ];
        $this->session->set('temp_checkout_data', $checkoutData); 

        return redirect()->to(base_url('pesanan/input_alamat')); 
    }
    
    public function review()
    {
        $sessionData = $this->session->get('temp_checkout_data');

        if (empty($sessionData)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Sesi checkout berakhir. Ulangi dari keranjang/detail barang.');
        }
        
        $alamat = [
            'penerima' => $this->request->getPost('penerima'),
            'telp' => $this->request->getPost('telp'),
            'alamat_lengkap_pesanan' => $this->request->getPost('alamat_lengkap'),
            'id_alamat' => 0,
        ];

        $subtotalProduk = $sessionData['calculatedTotalPrice'];
        $diskon = $subtotalProduk * 0.10;
        $ongkir = 20000;
        $totalFinal = $subtotalProduk - $diskon + $ongkir;

        $data = [
            'title' => 'Konfirmasi Pesanan',
            'keranjangItems' => $sessionData['keranjangItems'],
            'alamat' => $alamat,
            'subtotalProduk' => $subtotalProduk,
            'diskon' => $diskon,
            'ongkir' => $ongkir,
            'totalFinal' => $totalFinal,
            'metode_bayar' => 'QRIS',
            'metode_kirim' => 'Grab',
            'isCheckout' => $sessionData['isCheckout'],
        ];
        
        $this->session->set('checkout_data', $data); 
        $this->session->remove('temp_checkout_data');

        return view('pesanan/review', $data);
    }

    public function proses()
    {
        $checkoutData = $this->session->get('checkout_data');

        if (empty($checkoutData)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Data pesanan tidak ditemukan. Ulangi proses checkout.');
        }
        
        $alamatInputManual = $checkoutData['alamat'];
        
        $metodeBayar = $this->request->getPost('metode_pembayaran') ?? $checkoutData['metode_bayar'];
        $metodeKirim = $this->request->getPost('metode_pengiriman') ?? $checkoutData['metode_kirim'];
        
        $pesananData = [
            'id_user' => $this->user_id,
            'kode_pesanan' => 'ORD-' . time() . rand(100, 999), 
            'tanggal_pesan' => date('Y-m-d H:i:s'),
            'subtotal' => $checkoutData['subtotalProduk'], 
            'ongkir' => $checkoutData['ongkir'], 
            'diskon' => $checkoutData['diskon'], 
            'total_harga' => $checkoutData['totalFinal'], 
            
            'penerima_pesanan' => $alamatInputManual['penerima'], 
            'telp_pesanan' => $alamatInputManual['telp'], 
            'alamat_lengkap_pesanan' => $alamatInputManual['alamat_lengkap_pesanan'], 
            
            'metode_pembayaran' => $metodeBayar,
            'metode_pengiriman' => $metodeKirim,
            'status' => 'Menunggu Pembayaran',
        ];

        $this->pesananModel->insert($pesananData);
        $id_pesanan = $this->pesananModel->getInsertID();

        foreach ($checkoutData['keranjangItems'] as $item) {
            $this->detailPesananModel->insert([
                'id_pesanan' => $id_pesanan,
                'id_barang' => $item['id_barang'],
                'nama_barang' => $item['nama_barang'],
                'harga_barang' => $item['harga_jual'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal'],
            ]);

            if (isset($item['id_keranjang'])) {
                 $this->keranjangModel->delete($item['id_keranjang']);
            }
        }

        $this->session->remove('checkout_data');

        return redirect()->to(base_url('pesanan/invoice/' . $id_pesanan))->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function invoice($pesanan_id)
    {
        $pesanan = $this->pesananModel->find($pesanan_id);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw PageNotFoundException::forPageNotFound('Invoice tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $detail = $this->detailPesananModel->getDetailByPesananId($pesanan_id);
        
        $data = [
            'title' => 'Invoice Pembelian #' . $pesanan['kode_pesanan'],
            'pesanan' => $pesanan, 
            'detail' => $detail, 
        ];

        return view('pesanan/invoice', $data); 
    }
    
    public function bayar($id_pesanan)
    {
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        $data = [
            'title' => 'Pembayaran Pesanan #' . $pesanan['kode_pesanan'],
            'pesanan' => [
                'id_pesanan' => $pesanan['id_pesanan'],
                'kode_pesanan' => $pesanan['kode_pesanan'],
                'total_harga' => $pesanan['total_harga'],
                'status' => $pesanan['status'],
            ],
        ];

        return view('pesanan/pembayaran', $data);
    }
    
    public function update_status_pembayaran()
    {
        $id_pesanan = $this->request->getPost('id_pesanan');
        
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            return redirect()->to(base_url('pesanan'))->with('error', 'Pesanan tidak valid.');
        }

        $this->pesananModel->update($id_pesanan, [
            'status' => 'Menunggu Verifikasi', 
        ]);
        
        return redirect()->to(base_url('pesanan/invoice/' . $id_pesanan))->with('success', 'Konfirmasi pembayaran berhasil dikirim. Status pesanan Anda kini "Menunggu Verifikasi".');
    }
    
    public function hapus($id_pesanan)
    {
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        $this->detailPesananModel->where('id_pesanan', $id_pesanan)->delete();

        $this->pesananModel->delete($id_pesanan);

        return redirect()->to(base_url('pesanan'))->with('success', 'Pesanan berhasil dihapus.');
    }
    
    public function ubah($id_pesanan)
    {
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        $data = [
            'title' => 'Edit Pesanan',
            'pesanan' => $pesanan,
        ];

        return view('pesanan/ubah', $data);
    }
    
    public function update($id_pesanan)
    {
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'penerima_pesanan' => 'required|max_length[100]',
            'telp_pesanan' => 'required|max_length[15]',
            'alamat_lengkap_pesanan' => 'required|max_length[255]',
            'status' => 'required|max_length[50]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->pesananModel->update($id_pesanan, [
            'penerima_pesanan' => $this->request->getPost('penerima_pesanan'),
            'telp_pesanan' => $this->request->getPost('telp_pesanan'),
            'alamat_lengkap_pesanan' => $this->request->getPost('alamat_lengkap_pesanan'),
            'status' => $this->request->getPost('status'), 
        ]);
        
        return redirect()->to('/pesanan/detail/' . $id_pesanan)->with('success', 'Pesanan berhasil diperbarui.');
    }
    
    public function inputAlamat() 
    {
        $sessionData = $this->session->get('temp_checkout_data');

        if (empty($sessionData)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Sesi checkout berakhir. Ulangi dari keranjang/detail barang.');
        }
        
        $data = ['title' => 'Input Alamat Pengiriman'];
        return view('pesanan/input_alamat', $data);
    }
    
    public function lacakPesanan($id_pesanan)
    {
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        $data = [
            'title' => 'Lacak Pesanan #' . $pesanan['kode_pesanan'],
            'pesanan' => $pesanan,
            'status_history' => [
                ['status' => 'Dibuat', 'tanggal' => $pesanan['tanggal_pesan']],
                ['status' => 'Diproses', 'tanggal' => date('Y-m-d H:i:s', strtotime('+1 day', strtotime($pesanan['tanggal_pesan'])))],
                ['status' => 'Dikirim', 'tanggal' => date('Y-m-d H:i:s', strtotime('+2 days', strtotime($pesanan['tanggal_pesan'])))],
                ['status' => 'Sampai', 'tanggal' => date('Y-m-d H:i:s', strtotime('+3 days', strtotime($pesanan['tanggal_pesan'])))],
            ],
        ];
        return view('pesanan/lacak_pesanan', $data);
    }
}
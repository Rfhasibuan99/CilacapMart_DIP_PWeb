<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('pesanan', function ($routes) {
    $routes->get('/', 'Pesanan::index');

    $routes->post('prepare_review', 'Pesanan::prepare_review');
    $routes->post('review', 'Pesanan::review');                
    $routes->post('proses', 'Pesanan::proses');

    $routes->post('buy_now_start', 'Pesanan::buy_now_start');

    $routes->get('detail/(:num)', 'Pesanan::detail/$1');
    $routes->get('invoice/(:num)', 'Pesanan::invoice/$1');
    $routes->get('ubah/(:num)', 'Pesanan::ubah/$1');
    $routes->post('update/(:num)', 'Pesanan::update/$1');
    $routes->get('hapus/(:num)', 'Pesanan::hapus/$1');
    $routes->get('lacak-pesanan/(:num)', 'Pesanan::lacakPesanan/$1');
});
$routes->get('/pesanan/(:num)', 'Pesanan::detail/$1');



$routes->get('/layout/about', 'Page::about');
$routes->get('/akun', 'Akun::index');
$routes->get('/akun/ubah', 'Akun::ubah');
$routes->post('/akun/update', 'Akun::update');

$routes->get('/notifikasi', 'Notifikasi::index');
$routes->get('/chat', 'Chat::index');


$routes->get('/keranjang', 'Keranjang::index');
$routes->get('/keranjang/index', 'Keranjang::index');
$routes->post('/keranjang/tambah', 'Keranjang::tambah');
$routes->get('/keranjang/hapus/(:num)', 'Keranjang::hapus/$1');
$routes->get('/keranjang/kurang/(:num)', 'Keranjang::kurang/$1');
$routes->get('/keranjang/tambah_qty/(:num)', 'Keranjang::tambahQty/$1');
$routes->get('/keranjang/tambah/(:num)', 'Keranjang::tambah/$1');
$routes->get('/keranjang/kurang/(:num)', 'Keranjang::kurang/$1');


$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/proses', 'Checkout::proses');
$routes->post('checkout/beli-langsung', 'Checkout::beliLangsung');

$routes->get('pembayaran/(:num)', 'Pembayaran::index/$1');
$routes->post('pembayaran/proses/(:num)', 'Pembayaran::prosesBayar/$1');
$routes->post('pembayaran/update_status', 'Pembayaran::update_status');

$routes->get('/layout/tambah', 'Home::tambah');
$routes->post('/layout/simpan', 'Home::simpan');
$routes->get('/layout/ubah/(:num)', 'Home::ubah/$1');
$routes->put('/layout/update/(:num)', 'Home::update/$1');
$routes->get('/layout/hapus/(:num)', 'Home::hapus/$1');


$routes->get('/barang', 'Barang::index');
$routes->get('/barang/detail/(:num)', 'Barang::detail/$1');
$routes->get('/barang/tambah', 'Barang::tambah');
$routes->post('/barang/simpan', 'Barang::simpan');
$routes->get('barang/ubah/(:num)', 'Barang::ubah/$1');
$routes->put('/barang/update/(:num)', 'Barang::update/$1');
$routes->get('/barang/hapus/(:num)', 'Barang::hapus/$1');


$routes->get('social/login/(:alpha)', 'SocialAuth::login/$1');
$routes->get('social/login/(:alpha)/callback', 'SocialAuth::callback/$1');


$routes->group('chat', function ($routes) {
    $routes->get('(:num)', 'Chat::index/$1');
    $routes->get('/', 'Chat::menu');
    $routes->post('loadChat', 'Chat::loadChat');
    $routes->post('KirimPesan', 'Chat::kirimPesan');
    $routes->post('GetAllOrang', 'Chat::getAllOrang');
});

$routes->get('/saran', 'Saran::index');
$routes->post('/saran/simpan', 'Saran::simpan');
$routes->get('saran/daftar', 'Saran::daftar');
$routes->get('saran/detail/(:num)', 'Saran::detail/$1');

$routes->post('saran/update_status/(:num)', 'Saran::update_status/$1');

$routes->group('admin', ['filter' => 'login'], function ($routes) {
    $routes->get('chat', 'Chat::index');
    $routes->get('chat/(:num)', 'Chat::index/$1');
    $routes->get('chat/users', 'Chat::users');
    $routes->post('chat/send', 'Chat::send');
    $routes->get('chat/stream/(:num)', 'Chat::stream/$1');
    $routes->post('chat/ping', 'Chat::ping');
});

$routes->get('pesanan/input_alamat', 'Pesanan::inputAlamat');
$routes->get('pesanan/lacak-pesanan/(:num)', 'Pesanan::lacakPesanan/$1');
$routes->get('pesanan/invoice/(:num)', 'Pesanan::invoice/$1');
$routes->get('pesanan/detail/(:num)', 'Pesanan::detail/$1');
$routes->get('pesanan/detail/(:segment)', 'Pesanan::detail/$1');
$routes->get('pesanan/ubah/(:num)', 'Pesanan::ubah/$1');
$routes->post('pesanan/update/(:num)', 'Pesanan::update/$1');
$routes->get('pesanan/hapus/(:num)', 'Pesanan::hapus/$1');
$routes->get('pesanan/lacak-pesanan/(:num)', 'Pesanan::lacakPesanan/$1');
$routes->get('pesanan/bayar/(:num)', 'Pesanan::bayar/$1');
$routes->post('pesanan/update_status', 'Pesanan::update_status_pembayaran');
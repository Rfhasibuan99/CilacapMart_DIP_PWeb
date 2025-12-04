<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/layout/about', 'Page::about');


$routes->get('/', 'Page::index');
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

// $routes->get('/checkout', 'Checkout::index');
// $routes->post('/checkout/proses', 'Checkout::proses');
// $routes->post('/beli-sekarang', 'Keranjang::beliSekarang');



$routes->get('/pesanan', 'Pesanan::index');
$routes->get('/pesanan/detail/(:num)', 'Pesanan::detail/$1');
$routes->get('/pesanan/(:num)', 'Pesanan::detail/$1');


$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/proses', 'Checkout::proses');
// Untuk Alur Beli Langsung
$routes->post('checkout/beli-langsung', 'Checkout::beliLangsung'); 

// --- Routes untuk Pembayaran ---
$routes->get('pembayaran/(:num)', 'Pembayaran::index/$1');
$routes->post('pembayaran/proses/(:num)', 'Pembayaran::prosesBayar/$1');

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


$routes->get('auth/google', 'SocialAuth::google');
$routes->get('auth/google/callback', 'SocialAuth::googleCallback');

$routes->get('auth/apple', 'SocialAuth::apple');
$routes->post('auth/apple/callback', 'SocialAuth::appleCallback');

// $routes->get('admin', 'admin\Home::index'); // Home admin
// $routes->get('admin/pesanan', 'admin\Home::pesanan'); // Halaman produk di Home admin
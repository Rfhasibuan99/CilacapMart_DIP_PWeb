<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Page::index');
$routes->get('/akun', 'Akun::index');
$routes->get('/akun/edit', 'Akun::edit');
$routes->post('/akun/update', 'Akun::update');
$routes->get('/notifikasi', 'Notifikasi::index');
$routes->get('/chat', 'Chat::index');

$routes->get('/keranjang', 'Keranjang::index');
$routes->get('keranjang/index/(:num)', 'Keranjang::index/$1');
$routes->post('/keranjang/tambah', 'Keranjang::tambah');
$routes->get('/keranjang/hapus/(:num)', 'Keranjang::hapus/$1');
$routes->get('/keranjang/tambah/(:num)', 'Keranjang::tambah/$1');


$routes->get('/pesanan', 'Pesanan::index');
$routes->get('/pesanan/detail/(:num)', 'Pesanan::detail/$1');
$routes->get('/pesanan/checkout', 'Pesanan::checkout');
$routes->post('/pesanan/proses-checkout', 'Pesanan::prosesCheckout');
$routes->post('/pesanan/update-status/(:num)', 'Pesanan::updateStatus/$1');
// filter untuk landing login

// layout routes
// $routes->get('/layout', 'layout::index');
$routes->get('/layout/tambah', 'Dashboard::tambah');
$routes->post('/layout/simpan', 'Dashboard::simpan');
$routes->get('/layout/ubah/(:num)', 'Dashboard::ubah/$1');
$routes->put('/layout/update/(:num)', 'Dashboard::update/$1');
$routes->get('/layout/hapus/(:num)', 'Dashboard::hapus/$1');

// folder toko1 untuk Toko Jajan Koe
$routes->get('/toko1', 'Toko1::index');
$routes->get('/toko1/tambah', 'Toko1::tambah');
$routes->post('/toko1/simpan', 'Toko1::simpan');
$routes->get('/toko1/ubah/(:num)', 'Toko1::ubah/$1');
$routes->put('/toko1/update/(:num)', 'Toko1::update/$1');
$routes->get('/toko1/hapus/(:num)', 'Toko1::hapus/$1');

// folder Toko2
$routes->get('/toko2', 'Toko2::index');
$routes->get('/toko2/tambah', 'Toko2::tambah');
$routes->post('/toko2/simpan', 'Toko2::simpan');
$routes->get('/toko2/ubah/(:num)', 'Toko2::ubah/$1');
$routes->put('/toko2/update/(:num)', 'Toko2::update/$1');
$routes->get('/toko2/hapus/(:num)', 'Toko2::hapus/$1');

//folder toko3
$routes->get('/toko3', 'Toko3::index');
$routes->get('/toko3/tambah', 'Toko3::tambah');
$routes->post('/toko3/simpan', 'Toko3::simpan');
$routes->get('/toko3/ubah/(:num)', 'Toko3::ubah/$1');
$routes->put('/toko3/update/(:num)', 'Toko3::update/$1');
$routes->get('/toko3/hapus/(:num)', 'Toko3::hapus/$1');

//folder toko4
$routes->get('/toko4', 'Toko4::index');
$routes->get('/toko4/tambah', 'Toko4::tambah');
$routes->post('/toko4/simpan', 'Toko4::simpan');
$routes->get('/toko4/ubah/(:num)', 'Toko4::ubah/$1');
$routes->put('/toko4/update/(:num)', 'Toko4::update/$1');
$routes->get('/toko4/hapus/(:num)', 'Toko4::hapus/$1');

//folder toko5
$routes->get('/toko5', 'Toko5::index');
$routes->get('/toko5/tambah', 'Toko5::tambah');
$routes->post('/toko5/simpan', 'Toko5::simpan');
$routes->get('/toko5/ubah/(:num)', 'Toko5::ubah/$1');
$routes->put('/toko5/update/(:num)', 'Toko5::update/$1');
$routes->get('/toko5/hapus/(:num)', 'Toko5::hapus/$1');

// buat login google dan apple
$routes->get('auth/google', 'SocialAuth::google');
$routes->get('auth/google/callback', 'SocialAuth::googleCallback');

$routes->get('auth/apple', 'SocialAuth::apple');
$routes->post('auth/apple/callback', 'SocialAuth::appleCallback');


$routes->get('admin', 'admin\Dashboard::index'); // Dashboard admin
$routes->get('admin/barang', 'admin\Dashboard::barang'); // Dashboard admin
$routes->get('admin/pesanan', 'admin\Dashboard::pesanan'); // Halaman produk di dashboard adminaaaa
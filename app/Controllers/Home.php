<?php namespace App\Controllers;

use App\Models\BarangModel; // Import Model yang akan digunakan

class Home extends BaseController
{
 public function index()
 {
         $session = service('session');
        $auth = service('auth');
        

        if ($session->getFlashdata('message') && $auth !== null && $auth->check()) {
            

            
            $user = $auth->user();
            $nama = $user ? $user->username : 'Pengguna'; 
            
            $session->setFlashdata('welcome_alert', "Selamat Datang di Aplikasi $nama");
            
            
        }
     $barangModel = new BarangModel();

         $dataBarang = $barangModel->findAll(); 

         $data = [
        
         'barang' => $dataBarang, 
         'title'  => 'Daftar Barang Barang Yang Ada Di Cilacap Mart',
        
         ];

         return view('layout/home', $data); 
 }
}
<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;

class Dashboard extends BaseController
{
    protected $pesananModel;
    public function __construct()
    {
        $this->pesananModel = new PesananModel();
    }

    public function index()
    {
        return view('admin/dashboard', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function pesanan()
    {
        $data = [
            'title'   => 'Daftar Barang',
            'toko1' => $this->pesananModel->findAll()
        ];

        return view('admin/pesanan', $data);
    }
    public function logout()
{
    session()->destroy();
    return redirect()->to('/admin/login');
}

}

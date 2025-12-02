<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Page extends BaseController
{
    public function index()
    {
        $cari = $this->request->getVar('cari');
        $barangModel = new BarangModel();
        $barang = $barangModel->getBarang();

        return view('layout/home', ['barang' => $barang]);
    }
}

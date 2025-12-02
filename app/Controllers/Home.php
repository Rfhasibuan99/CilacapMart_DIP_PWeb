<?php

namespace App\Controllers;
use App\Models\BarangModel;

// use App\Models\ShopModel;

class Home extends BaseController
{

    public function index()
    {
        $model = new BarangModel();
        $data['barang'] = $model->findAll();
        return view('layout/home', $data);
    }
    // public function detail($idbarang)
    // {
    //     $data[]
    // }
}
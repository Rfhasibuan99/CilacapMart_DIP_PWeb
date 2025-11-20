<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function index()
    {
        $cari = $this->request->getVar('cari');
        $shops = [];

        return view('layout/home', ['shops' => $shops]);
    }
}

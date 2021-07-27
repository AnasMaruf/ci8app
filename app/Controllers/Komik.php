<?php

namespace App\Controllers;

class Komik extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Komik |Latihan Codeigniter 4'
        ];
        return view('komik/index', $data);
    }
}

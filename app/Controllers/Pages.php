<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home |Latihan Codeigniter 4',
            'nama'  => "Muhammad Anas Ma'ruf"
        ];
        return view('pages/index', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'About Me |Latihan Codeigniter 4',
            'profil' => [
                'nama'      => "Muhammad Anas Ma'ruf",
                'umur'      => '20',
                'pekerjaan' => 'Programmer'
            ]
        ];
        return view('pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact |Latihan Codeigniter 4',
            'alamat' => [
                [
                    'tipe'  => 'Rumah',
                    'alamat' => 'Jl. Wahid Hasim No.14',
                    'kota'  => 'Jepara'
                ],
                [
                    'tipe'  => 'Kantor',
                    'alamat' => 'Jl. Singaraja No.15',
                    'kota'  => 'Bali'
                ],
                [
                    'tipe'  => 'Apartment',
                    'alamat' => 'Jl. Ahmad Yani No.56',
                    'kota'  => 'Semarang'
                ],
            ]
        ];
        return view('pages/contact', $data);
    }
}

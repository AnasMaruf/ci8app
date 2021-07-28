<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Komik |Latihan Codeigniter 4',
            'komik' =>  $this->komikModel->getKomik()
        ];
        return view('komik/index', $data);
    }
    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik |Latihan Codeigniter 4',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // Jika komik tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan');
        }

        return view('komik/detail', $data);
    }
    public function create()
    {
        $data = [
            'title'      => 'Form Tambah Data Komik |Latihan Codeigniter 4',
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }
    public function save()
    {
        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komiku.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu basar',
                    'is_image' => 'File yang anda pilih bukan gambar',
                    'mime_in' => 'File yang anda pilih bukan gambar'
                ]
            ]

        ])) {
            return redirect()->to('/komik/create')->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // Apakah tidak ada gambar yang diupload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan file ke folder img
            $fileSampul->move('img', $namaSampul);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul'     => $this->request->getVar('judul'),
            'slug'      => $slug,
            'penulis'   => $this->request->getVar('penulis'),
            'penerbit'  => $this->request->getVar('penerbit'),
            'sampul'    => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/komik');
    }
    public function delete($id)
    {
        $komik = $this->komikModel->find($id);
        // cek jika gambar default.jpg
        if ($komik['sampul'] != 'default.jpg') {
            // hapus gambar 
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/komik');
    }
    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Codeigniter',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];
        return view('komik/edit', $data);
    }
    public function update($id)
    {
        // cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));

        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule = 'required';
        } else {
            $rule = 'required|is_unique[komiku.judul]';
        }

        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule,
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul, 1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File yang anda pilih bukan gambar',
                    'mime_in' => 'File yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        // cek gambar, apakah gambar tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan ke folder img
            $fileSampul->move('img', $namaSampul);
            // hapus file lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id'        => $id,
            'judul'     => $this->request->getVar('judul'),
            'slug'      => $slug,
            'penulis'   => $this->request->getVar('penulis'),
            'penerbit'  => $this->request->getVar('penerbit'),
            'sampul'    => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/komik');
    }
}

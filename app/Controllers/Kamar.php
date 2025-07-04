<?php

namespace App\Controllers;

use App\Models\Kamar as KamarModel;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;
use Hermawan\DataTables\DataTable;

class Kamar extends ResourceController
{
    protected $kamarModel;

    public function __construct()
    {
        $this->kamarModel = new KamarModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kamar - Admin Panel',
            'pageTitle' => 'Manajemen Kamar',
            'pageDescription' => 'Kelola data kamar dengan mudah',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Kamar', 'link' => '#', 'active' => true]
            ]
        ];

        return view('kamar/index', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('kamar')
                          ->select('idkamar, nama, harga, kapasitas, status_kamar, created_at');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->format('harga', function($value) {
                    return 'Rp ' . number_format($value, 0, ',', '.');
                })
                ->format('kapasitas', function($value) {
                    return $value . ' orang';
                })
                ->format('status_kamar', function($value) {
                    if ($value == '1') {
                        return '<span class="badge bg-success">Tersedia</span>';
                    } else {
                        return '<span class="badge bg-danger">Tidak Tersedia</span>';
                    }
                })
                ->format('created_at', function($value) {
                    return date('d-m-Y H:i:s', strtotime($value));
                })
                ->add('action', function($row) {
                    return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-info btn-sm btn-view" data-id="'.$row->idkamar.'">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="'.site_url('kamar/edit/'.$row->idkamar).'" class="btn btn-warning btn-sm btn-edit" data-id="'.$row->idkamar.'">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->idkamar.'" data-nama="'.$row->nama.'">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
                })
                ->toJson();
        }
        
        return $this->failUnauthorized('Tidak dapat mengakses secara langsung');
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Kamar - Admin Panel',
            'pageTitle' => 'Tambah Data Kamar',
            'pageDescription' => 'Form untuk menambahkan data kamar baru',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Kamar', 'link' => site_url('kamar')],
                ['label' => 'Tambah', 'link' => '#', 'active' => true]
            ],
            'validation' => Services::validation()
        ];

        return view('kamar/create', $data);
    }

    public function create()
    {
        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'harga' => 'required|numeric',
            'kapasitas' => 'required|numeric',
            'deskripsi' => 'required',
            'status_kamar' => 'required|in_list[1,2]',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];
        
        $errorMessages = [
            'nama' => [
                'required' => 'Nama kamar harus diisi',
                'min_length' => 'Nama kamar minimal 3 karakter',
                'max_length' => 'Nama kamar maksimal 100 karakter'
            ],
            'harga' => [
                'required' => 'Harga kamar harus diisi',
                'numeric' => 'Harga kamar harus berupa angka'
            ],
            'kapasitas' => [
                'required' => 'Kapasitas kamar harus diisi',
                'numeric' => 'Kapasitas kamar harus berupa angka'
            ],
            'deskripsi' => [
                'required' => 'Deskripsi kamar harus diisi'
            ],
            'status_kamar' => [
                'required' => 'Status kamar harus dipilih',
                'in_list' => 'Status kamar tidak valid'
            ],
            'gambar' => [
                'uploaded' => 'Gambar kamar harus diupload',
                'max_size' => 'Ukuran gambar maksimal 2MB',
                'is_image' => 'File yang diupload harus berupa gambar',
                'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG'
            ]
        ];

        if (!$this->validate($rules, $errorMessages)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
        
        // Upload file gambar
        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        
        // Pindahkan ke folder uploads/kamar
        $gambar->move(WRITEPATH . 'uploads/kamar', $namaGambar);
        
        // Simpan data
        $data = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'kapasitas' => $this->request->getPost('kapasitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status_kamar' => $this->request->getPost('status_kamar'),
            'gambar' => $namaGambar
        ];
        
        $this->kamarModel->insert($data);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data kamar berhasil ditambahkan',
                'redirect' => site_url('kamar')
            ]);
        } else {
            return redirect()->to('kamar')->with('success', 'Data kamar berhasil ditambahkan');
        }
    }

    public function edit($id = null)
    {
        $kamar = $this->kamarModel->find($id);
        
        if (empty($kamar)) {
            return redirect()->to('kamar')->with('error', 'Data kamar tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Kamar - Admin Panel',
            'pageTitle' => 'Edit Data Kamar',
            'pageDescription' => 'Form untuk mengubah data kamar',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Kamar', 'link' => site_url('kamar')],
                ['label' => 'Edit', 'link' => '#', 'active' => true]
            ],
            'kamar' => $kamar,
            'validation' => Services::validation()
        ];

        return view('kamar/edit', $data);
    }

    public function update($id = null)
    {
        $kamar = $this->kamarModel->find($id);
        
        if (empty($kamar)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data kamar tidak ditemukan'
                ]);
            } else {
                return redirect()->to('kamar')->with('error', 'Data kamar tidak ditemukan');
            }
        }
        
        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'harga' => 'required|numeric',
            'kapasitas' => 'required|numeric',
            'deskripsi' => 'required',
            'status_kamar' => 'required|in_list[1,2]',
            'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];
        
        $errorMessages = [
            'nama' => [
                'required' => 'Nama kamar harus diisi',
                'min_length' => 'Nama kamar minimal 3 karakter',
                'max_length' => 'Nama kamar maksimal 100 karakter'
            ],
            'harga' => [
                'required' => 'Harga kamar harus diisi',
                'numeric' => 'Harga kamar harus berupa angka'
            ],
            'kapasitas' => [
                'required' => 'Kapasitas kamar harus diisi',
                'numeric' => 'Kapasitas kamar harus berupa angka'
            ],
            'deskripsi' => [
                'required' => 'Deskripsi kamar harus diisi'
            ],
            'status_kamar' => [
                'required' => 'Status kamar harus dipilih',
                'in_list' => 'Status kamar tidak valid'
            ],
            'gambar' => [
                'max_size' => 'Ukuran gambar maksimal 2MB',
                'is_image' => 'File yang diupload harus berupa gambar',
                'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG'
            ]
        ];

        if (!$this->validate($rules, $errorMessages)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $this->validator->getErrors()
                ]);
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
        
        // Siapkan data untuk update
        $data = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'kapasitas' => $this->request->getPost('kapasitas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status_kamar' => $this->request->getPost('status_kamar')
        ];
        
        // Cek apakah ada upload gambar baru
        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($kamar['gambar']) && file_exists(WRITEPATH . 'uploads/kamar/' . $kamar['gambar'])) {
                unlink(WRITEPATH . 'uploads/kamar/' . $kamar['gambar']);
            }
            
            // Upload gambar baru
            $namaGambar = $gambar->getRandomName();
            $gambar->move(WRITEPATH . 'uploads/kamar', $namaGambar);
            
            // Tambahkan ke data update
            $data['gambar'] = $namaGambar;
        }
        
        // Update data kamar
        $this->kamarModel->update($id, $data);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data kamar berhasil diperbarui',
                'redirect' => site_url('kamar')
            ]);
        } else {
            return redirect()->to('kamar')->with('success', 'Data kamar berhasil diperbarui');
        }
    }

    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $kamar = $this->kamarModel->find($id);
            
            if (empty($kamar)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data kamar tidak ditemukan'
                ]);
            }
            
            // Format data untuk ditampilkan
            $kamar['harga_formatted'] = 'Rp ' . number_format($kamar['harga'], 0, ',', '.');
            $kamar['status_text'] = $kamar['status_kamar'] == '1' ? 'Tersedia' : 'Tidak Tersedia';
            $kamar['gambar_url'] = base_url('writable/uploads/kamar/' . $kamar['gambar']);
            $kamar['created_at_formatted'] = date('d-m-Y H:i:s', strtotime($kamar['created_at']));
            $kamar['updated_at_formatted'] = date('d-m-Y H:i:s', strtotime($kamar['updated_at']));
            
            return $this->response->setJSON([
                'status' => true,
                'data' => $kamar
            ]);
        } else {
            return redirect()->to('kamar');
        }
    }

    public function delete($id = null)
    {
        if ($this->request->isAJAX()) {
            $kamar = $this->kamarModel->find($id);
            
            if (empty($kamar)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data kamar tidak ditemukan'
                ]);
            }
            
            // Soft delete
            $this->kamarModel->delete($id);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data kamar berhasil dihapus'
            ]);
        } else {
            return $this->failUnauthorized('Tidak dapat mengakses secara langsung');
        }
    }
} 
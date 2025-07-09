<?php

namespace App\Controllers;

use App\Models\Tamu as TamuModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;
use Hermawan\DataTables\DataTable;

class Tamu extends ResourceController
{
    protected $tamuModel;
    protected $userModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Tamu - Wisma Citra Sabaleh',
            'pageTitle' => 'Manajemen Tamu',
            'pageDescription' => 'Kelola data tamu dengan mudah',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Tamu', 'link' => '#', 'active' => true]
            ]
        ];

        return view('tamu/index', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('tamu')
                          ->select('nik, nama,nohp, jenkel, iduser')
                          ->where('deleted_at IS NULL');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->add('action', function($row) {
                    $buttons = '
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-info btn-detail" data-id="'.$row->nik.'">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="'.site_url('tamu/edit/'.$row->nik).'" class="btn btn-warning btn-edit" data-id="'.$row->nik.'">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-delete" data-id="'.$row->nik.'" data-nama="'.$row->nama.'" data-url="'.site_url('tamu/delete/').$row->nik.'">
                            <i class="fas fa-trash"></i>
                        </button>';
                    
                    // Tambahkan tombol kunci jika iduser kosong
                    if (empty($row->iduser) || $row->iduser === null) {
                        $buttons .= '
                        <button type="button" class="btn btn-success btn-create-user" data-nik="'.$row->nik.'" data-nama="'.$row->nama.'">
                            <i class="fas fa-key"></i>
                        </button>';
                    }
                    
                    $buttons .= '</div>';
                    
                    return $buttons;
                })
                ->edit('jenkel', function($row) {
                    return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->edit('tgllahir', function($row) {
                    return date('d-m-Y', strtotime($row->tgllahir));
                })
                ->edit('created_at', function($row) {
                    return date('d-m-Y H:i:s', strtotime($row->created_at));
                })
                ->hide('iduser')
                ->toJson();
        } else {
            return $this->failUnauthorized('Tidak dapat mengakses secara langsung');
        }
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Tamu - Wisma Citra Sabaleh',
            'pageTitle' => 'Tambah Data Tamu',
            'pageDescription' => 'Form untuk menambahkan data tamu baru',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Tamu', 'link' => site_url('tamu')],
                ['label' => 'Tambah', 'link' => '#', 'active' => true]
            ]
        ];

        return view('tamu/create', $data);
    }

    public function create()
    {
        // Validasi input
        $rules = [
            'nik' => 'required|min_length[16]|max_length[16]|is_unique[tamu.nik]',
            'nama' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required',
            'nohp' => 'required|min_length[10]|max_length[15]',
            'jenkel' => 'required|in_list[L,P]',
            'tgllahir' => 'required|valid_date',
        ];
        
        $errorMessages = [
            'nik' => [
                'required' => 'NIK harus diisi',
                'min_length' => 'NIK harus 16 digit',
                'max_length' => 'NIK harus 16 digit',
                'is_unique' => 'NIK sudah digunakan'
            ],
            'nama' => [
                'required' => 'Nama harus diisi',
                'min_length' => 'Nama minimal 3 karakter',
                'max_length' => 'Nama maksimal 100 karakter'
            ],
            'alamat' => [
                'required' => 'Alamat harus diisi'
            ],
            'nohp' => [
                'required' => 'No. HP harus diisi',
                'min_length' => 'No. HP minimal 10 digit',
                'max_length' => 'No. HP maksimal 15 digit'
            ],
            'jenkel' => [
                'required' => 'Jenis kelamin harus dipilih',
                'in_list' => 'Jenis kelamin tidak valid'
            ],
            'tgllahir' => [
                'required' => 'Tanggal lahir harus diisi',
                'valid_date' => 'Format tanggal lahir tidak valid'
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
        
        // Simpan data
        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
        ];
        
        $this->tamuModel->insert($data);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data tamu berhasil ditambahkan',
                'redirect' => site_url('tamu')
            ]);
        } else {
            return redirect()->to('tamu')->with('success', 'Data tamu berhasil ditambahkan');
        }
    }

    public function edit($id = null)
    {
        $tamu = $this->tamuModel->find($id);
        
        if (empty($tamu)) {
            return redirect()->to('tamu')->with('error', 'Data tamu tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Tamu - Wisma Citra Sabaleh',
            'pageTitle' => 'Edit Data Tamu',
            'pageDescription' => 'Form untuk mengubah data tamu',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Tamu', 'link' => site_url('tamu')],
                ['label' => 'Edit', 'link' => '#', 'active' => true]
            ],
            'tamu' => $tamu
        ];

        return view('tamu/edit', $data);
    }

    public function update($id = null)
    {
        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required',
            'nohp' => 'required|min_length[10]|max_length[15]',
            'jenkel' => 'required|in_list[L,P]',
            'tgllahir' => 'required|valid_date',
        ];
        
        if (!$this->validate($rules)) {
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
        
        // Update data
        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
            'iduser' => session()->get('id') ?? null // Ambil ID user dari session, jika tidak ada, set null
        ];
        
        $this->tamuModel->update($id, $data);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data tamu berhasil diperbarui',
                'redirect' => site_url('tamu')
            ]);
        } else {
            return redirect()->to('tamu')->with('success', 'Data tamu berhasil diperbarui');
        }
    }

    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $tamu = $db->table('tamu')
                ->select('tamu.*, users.username, users.email')
                ->join('users', 'users.id = tamu.iduser', 'left')
                ->where('tamu.nik', $id)
                ->where('tamu.deleted_at IS NULL', null, false)
                ->get()
                ->getRowArray();
            
            if (empty($tamu)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data tamu tidak ditemukan'
                ]);
            }
            
            // Format data untuk ditampilkan
            $tamu['jenkel'] = $tamu['jenkel'] == 'L' ? 'Laki-laki' : 'Perempuan';
            $tamu['tgllahir'] = date('d-m-Y', strtotime($tamu['tgllahir']));
            $tamu['created_at'] = date('d-m-Y H:i:s', strtotime($tamu['created_at']));
            $tamu['updated_at'] = date('d-m-Y H:i:s', strtotime($tamu['updated_at']));
            
            // Tambahkan informasi akun (jika ada)
            $tamu['has_account'] = !empty($tamu['iduser']);
            
            return $this->response->setJSON([
                'status' => true,
                'data' => $tamu
            ]);
        } else {
            return redirect()->to('tamu');
        }
    }

    public function delete($id = null)
    {
        if ($this->request->isAJAX()) {
            $tamu = $this->tamuModel->find($id);
            
            if (empty($tamu)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data tamu tidak ditemukan'
                ]);
            }
            $this->tamuModel->delete($id);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data tamu berhasil dihapus'
            ]);
        } else {
            return $this->failUnauthorized('Tidak dapat mengakses secara langsung');
        }
    }
    
    /**
     * Membuat akun user baru untuk tamu
     */
    public function createUser()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Tidak dapat mengakses secara langsung');
        }
        
        // Validasi input
        $rules = [
            'nik_tamu' => 'required|exists[tamu.nik]',
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];
        
        $customErrors = [
            'nik_tamu' => [
                'exists' => 'Data tamu tidak ditemukan'
            ],
            'username' => [
                'required' => 'Username harus diisi',
                'min_length' => 'Username minimal 3 karakter',
                'is_unique' => 'Username sudah digunakan'
            ],
            'email' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Format email tidak valid',
                'is_unique' => 'Email sudah digunakan'
            ],
            'password' => [
                'required' => 'Password harus diisi',
                'min_length' => 'Password minimal 6 karakter'
            ],
            'confirm_password' => [
                'required' => 'Konfirmasi password harus diisi',
                'matches' => 'Konfirmasi password tidak cocok'
            ]
        ];
        
        if (!$this->validate($rules, $customErrors)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Ambil data tamu
        $nikTamu = $this->request->getPost('nik_tamu');
        $tamu = $this->tamuModel->find($nikTamu);
        
        if (empty($tamu)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }
        
        // Cek apakah tamu sudah memiliki user
        if (!empty($tamu['iduser'])) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Tamu ini sudah memiliki akun user'
            ]);
        }
        
        // Start transaksi database
        $db = db_connect();
        $db->transBegin();
        
        try {
            // Buat user baru
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role' => 'tamu',
                'status' => 'active'
            ];
            
            $this->userModel->insert($userData);
            $userId = $this->userModel->getInsertID();
            
            // Update data tamu dengan ID user
            $this->tamuModel->update($nikTamu, ['iduser' => $userId]);
            
            // Commit transaksi
            $db->transCommit();
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Akun user berhasil dibuat untuk tamu',
                'user_id' => $userId
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            $db->transRollback();
            
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal membuat akun user: ' . $e->getMessage()
            ]);
        }
    }
} 
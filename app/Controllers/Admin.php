<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard - Admin Panel',
            'pageTitle' => 'Dashboard',
            'pageDescription' => 'Selamat datang di Panel Admin',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => '#', 'active' => true]
            ]
        ];

        return view('admin/dashboard', $data);
    }

    public function users()
    {
        $data = [
            'title' => 'Pengguna - Admin Panel',
            'pageTitle' => 'Manajemen Pengguna',
            'pageDescription' => 'Kelola data pengguna sistem',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Pengguna', 'link' => '#', 'active' => true]
            ]
        ];

        return view('admin/users', $data);
    }

    public function profile()
    {
        $data = [
            'title' => 'Profil - Admin Panel',
            'pageTitle' => 'Profil Saya',
            'pageDescription' => 'Kelola data profil Anda',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Profil', 'link' => '#', 'active' => true]
            ]
        ];

        return view('admin/profile', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'Pengaturan - Admin Panel',
            'pageTitle' => 'Pengaturan Sistem',
            'pageDescription' => 'Konfigurasi pengaturan sistem',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'link' => site_url('admin')],
                ['label' => 'Pengaturan', 'link' => '#', 'active' => true]
            ]
        ];

        return view('admin/settings', $data);
    }
} 
<?php

namespace App\Models;

use CodeIgniter\Model;

class Kamar extends Model
{
    protected $table            = 'kamar';
    protected $primaryKey       = 'idkamar';
    protected $protectFields    = true;
    protected $allowedFields    = ['idkamar', 'nama', 'harga','kapasitas','deskripsi','gambar', 'status_kamar'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}
<?php

namespace App\Models;

use CodeIgniter\Model;

class Tamu extends Model
{
    protected $table            = 'tamu';
    protected $primaryKey       = 'nik';
    protected $protectFields    = true;
    protected $allowedFields    = ['nik', 'nama', 'alamat', 'nohp', 'jenkel','tgllahir','iduser'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}
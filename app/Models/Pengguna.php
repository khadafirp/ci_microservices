<?php

namespace App\Models;

use CodeIgniter\Model;

class Pengguna extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengguna';
    protected $primaryKey       = 'pengguna_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pengguna_id', 'email', 'password', 'nama_lengkap', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}

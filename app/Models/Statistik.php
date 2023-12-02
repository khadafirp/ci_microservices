<?php

namespace App\Models;

use CodeIgniter\Model;

class Statistik extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'statistik';
    protected $primaryKey       = 'statistik_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['statistik_id', 'news_id', 'kategori_id', 'tahun', 'bulan', 'tanggal', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

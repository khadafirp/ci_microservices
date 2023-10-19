<?php

namespace App\Models;

use CodeIgniter\Model;

class Berita extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'berita';
    protected $primaryKey       = 'news_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['news_id', 'news_title', 'news_description', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}

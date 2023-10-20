<?php

namespace App\Models;

use CodeIgniter\Model;

class ListToken extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'list_token';
    protected $primaryKey       = 'token_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pengguna_id', 'token', 'exp_time', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class UserStatusModel extends Model
{
    protected $table = 'user_status';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_id', 'last_seen'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
}

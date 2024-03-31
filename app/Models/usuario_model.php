<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class usuario_model extends Model
{
    protected $table = 'cliente';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['correoElectronico', 'ccontrasena', 'nombres', 'apellidos'];
}

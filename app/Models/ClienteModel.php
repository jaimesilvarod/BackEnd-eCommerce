<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'idCliente';
    protected $allowedFields = ['nombres', 'apellidos', 'idDocumento', 'numeroDocumento', 'fechaNacimiento', 'correoElectronico', 'direccion', 'idCiudad', 'telefono', 'celular', 'contrasena'];

    protected $validationRules = [
        'nombres' => 'required|min_length[3]|max_length[50]',
        'apellidos' => 'required|min_length[3]|max_length[50]',
        'idDocumento' => 'required|numeric',
        'numeroDocumento' => 'required|min_length[5]|max_length[20]',
        'fechaNacimiento' => 'valid_date',
        'correoElectronico' => 'required|valid_email|is_unique[clientes.correoElectronico]',
        'direccion' => 'max_length[255]',
        'idCiudad' => 'required|numeric',
        'telefono' => 'numeric',
        'celular' => 'required|numeric',
        'contrasena' => 'required|min_length[8]'
    ];

    protected $validationMessages = [
        'correoElectronico.is_unique' => 'El correo electrónico ya está registrado en la base de datos.'
    ];
}


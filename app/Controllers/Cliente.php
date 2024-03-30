<?php

namespace App\Controllers;

use App\Models\ClienteModel;

class Cliente extends BaseController
{
    public function index()
    {
        return view('cliente/index');
    }

    public function create()
    {
        return view('cliente/create');
    }

    public function store()
    {
        $model = new ClienteModel();

        $data = [
            'nombres' => $this->request->getPost('nombres'),
            'apellidos' => $this->request->getPost('apellidos'),
            'idDocumento' => $this->request->getPost('idDocumento'),
            'numeroDocumento' => $this->request->getPost('numeroDocumento'),
            'fechaNacimiento' => $this->request->getPost('fechaNacimiento'),
            'correoElectronico' => $this->request->getPost('correoElectronico'),
            'direccion' => $this->request->getPost('direccion'),
            'idCiudad' => $this->request->getPost('idCiudad'),
            'telefono' => $this->request->getPost('telefono'),
            'celular' => $this->request->getPost('celular'),
            'contrasena' => password_hash($this->request->getPost('contrasena'), PASSWORD_DEFAULT),
        ];

        if ($model->insert($data)) {
            return redirect()->to('cliente')->with('success', 'Cliente creado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear el cliente.');
        }
    }

    public function edit($id)
    {
        $model = new ClienteModel();
        $cliente = $model->find($id);

        if (!$cliente) {
            return redirect()->to('cliente')->with('error', 'Cliente no encontrado.');
        }

        return view('cliente/edit', ['cliente' => $cliente]);
    }

    public function update($id)
    {
        $model = new ClienteModel();

        $data = [
            'nombres' => $this->request->getPost('nombres'),
            'apellidos' => $this->request->getPost('apellidos'),
            'idDocumento' => $this->request->getPost('idDocumento'),
            'numeroDocumento' => $this->request->getPost('numeroDocumento'),
            'fechaNacimiento' => $this->request->getPost('fechaNacimiento'),
            'correoElectronico' => $this->request->getPost('correoElectronico'),
            'direccion' => $this->request->getPost('direccion'),
            'idCiudad' => $this->request->getPost('idCiudad'),
            'telefono' => $this->request->getPost('telefono'),
            'celular' => $this->request->getPost('celular'),
        ];

        if ($this->request->getPost('contrasena')) {
            $data['contrasena'] = password_hash($this->request->getPost('contrasena'), PASSWORD_DEFAULT);
        }

        if ($model->update($id, $data)) {
            return redirect()->to('cliente')->with('success', 'Cliente actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el cliente.');
        }
    }

    public function delete($id)
    {
        $model = new ClienteModel();

        if ($model->delete($id)) {
            return redirect()->to('cliente')->with('success', 'Cliente eliminado correctamente.');
        } else {
            return redirect()->to('cliente')->with('error', 'Error al eliminar el cliente.');
        }
    }
}

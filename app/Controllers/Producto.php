<?php

namespace App\Controllers;

use App\Models\producto_model;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions;

class Producto extends BaseController
{
    public function getjson_ListadoProductos($ArrayName)
    {
        $model = new producto_model();
        $datos = $model->getListado();
        if ($datos)
            if ($ArrayName != "")
                echo json_encode([$ArrayName => $datos]);
            else
                echo json_encode($datos);
    }

    public function addproducto(): string
    {
        return view('producto/addproducto');
    }

    public function listadoproductos(): string
    {
        return view('producto/listadoproductos');
    }

    public function viewProductosGrid($idCategoria, $idMarca): string
    {
        if (!is_numeric($idCategoria))     return $this->sendBadRequest('IDCategoría debe ser numérico');
        if (!is_numeric($idMarca))         return $this->sendBadRequest('IDMarca debe ser numérico');

        $model = new producto_model();
        $productos = $model->getListadoGrid($idCategoria, $idMarca);
        if ($productos) {
            return view('producto/grid', ['productos' => $productos]);
        } else {
            return $this->sendResponse(['message' => 'No se encontraron productos'], ResponseInterface::HTTP_NOT_FOUND);
        }
    }

    public function insertProducto()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'idCategoria' => 'required|numeric',
            'idMarca' => 'required|numeric',
            'modelo' => 'required|min_length[3]|max_length[50]',
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'required|min_length[3]|max_length[255]',
            'precio' => 'required|numeric',
            'pvp' => 'required|numeric',
            'impuesto' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[20]'
        ];

        if (!$this->validate($rules)) {
            return $this->sendResponse(['validations' => $this->validator->getErrors()], ResponseInterface::HTTP_BAD_REQUEST);
        }

        try {
            $model = new producto_model();
            $model->insert($input);
            return $this->sendResponse(['message' => 'Producto creado correctamente']);
        } catch (\Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProducto($id)
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'idCategoria' => 'required|numeric',
            'idMarca' => 'required|numeric',
            'modelo' => 'required|min_length[3]|max_length[50]',
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'required|min_length[3]|max_length[255]',
            'precio' => 'required|numeric',
            'pvp' => 'required|numeric',
            'impuesto' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[20]'
        ];

        if (!$this->validate($rules)) {
            return $this->sendResponse(['validations' => $this->validator->getErrors()], ResponseInterface::HTTP_BAD_REQUEST);
        }

        try {
            $model = new producto_model();
            $model->update($id, $input);
            return $this->sendResponse(['message' => 'Producto actualizado correctamente']);
        } catch (\Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteProducto($id)
    {
        if (!is_numeric($id)) {
            return $this->sendBadRequest('IDProducto debe ser numérico');
        }

        $model = new producto_model();
        $producto = $model->find($id);
        if (!$producto) {
            return $this->sendResponse(['message' => 'Producto no encontrado'], ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            $model->delete($id);
            return $this->sendResponse(['message' => 'Producto eliminado correctamente']);
        } catch (\Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}


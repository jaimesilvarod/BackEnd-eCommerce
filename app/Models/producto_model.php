<?php

namespace App\Models;

use CodeIgniter\Model;

class producto_model extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'idProducto';
    protected $allowedFields = ['idCategoria', 'idMarca', 'modelo', 'nombre', 'descripcion', 'precio', 'pvp', 'impuesto'];

    public function execQuery($Query)
    {
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0 ? $query : false;
    }

    public function getListado()
    {
        $query = $this->db->query("SELECT idProducto, idCategoria, idMarca, nombre, descripcion, precio, pvp, impuesto FROM producto ORDER BY idProducto");
        return $query->getResultArray();
    }

    public function findById($id)
    {
        $query = $this->db->query("SELECT idProducto, idCategoria, idMarca, nombre, descripcion, precio, pvp, impuesto FROM producto WHERE idProducto = $id");
        return $query->getRowArray();
    }

    public function getListadoGrid($IDCat, $IDMarca)
    {
        $sql = "SELECT idProducto, idCategoria, idMarca, nombre, descripcion, precio, pvp, impuesto FROM producto";
        if ($IDCat > 0)  $sql .= " WHERE idCategoria = $IDCat";
        if ($IDMarca > 0) {
            if ($IDCat > 0) $sql .= " AND";
            else $sql .= " WHERE";
            $sql .= " idMarca = $IDMarca";
        }

        $sql .= " ORDER BY idProducto";

        $query = $this->execQuery($sql);
        if ($query) {
            return ['data' => $query->getResultArray()];
        } else {
            return false;
        }
    }
}


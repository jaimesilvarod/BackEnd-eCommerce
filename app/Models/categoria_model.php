<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class categoria_model extends Model
{
    protected $table = 'categoria';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['nombre'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
    
    public function getListado()
    {
        $query = $this->db->query("SELECT Concat('r_',idCategoria) as dt_rowid, idCategoria as id, nombre as descripcion  FROM categoria  order by idCategoria;");
        return $query->getResultArray();
    }

    public function findById($id)
    {
       return $this->asArray()->where(['id' => $id])->first();
    }

    public function hasSubCategorias($idc) {
        $sql = "SELECT * FROM subcategoria_lugar where categoria_id=$idc";
        $query = $this->db->query($sql);
        return $query->getNumRows()>0?true:false;   
    }

    public function getCategoria($ID)
    {
        $sql = "SELECT Concat('r_', c.id) as dt_rowid, c.* FROM categoria_lugar c WHERE c.id=$ID";
        $query = $this->execQuery($sql);
        if($query)
             return $query->getRowArray();
        else
            return false;

    }
   
}
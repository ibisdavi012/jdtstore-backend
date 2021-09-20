<?php 

namespace App\Models;
 
/**
* BaseModel - All models extends this Model.
*
* @author      David Márquez <ibisdavi012@gmail.com>
* @license     MIT
* 
*/

class BaseModel {
   
    protected $db_table;

    protected function setDbTable($db_table) {
        $this->db_table = $db_table;
    }

    protected function getDbTable() {
        return $db_table;
    }

    public function getAll() {
    }
}

<?php 

namespace App\Models;
use PDO; 
/**
* BaseModel - All models extends this Model.
*
* @author      David Márquez <ibisdavi012@gmail.com>
* @license     MIT
* 
*/

abstract class BaseModel {
   
    protected $db_table;

    protected $db_connection_handle = null;

    protected $query_statement = null;
    
    public function __construct($db_table) {
        $this->db_table = $db_table;
        $this->connect();
    }

    private function connect() 
    {    
        try {
            $dsn = sprintf("mysql:host=%s;dbname=%s",DATABASE_HOST,DATABASE_NAME);
            $this->db_connection_handle = new PDO($dsn, DATABASE_USER, DATABASE_PASSWORD);
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    protected function getDbTable() {
        return $db_table;
    }

    public function execute_query($query,$parameters = array()) {
        if(!$this->db_connection_handle) {
            return null;
        }
        $this->query_statement = $this->db_connection_handle->prepare($query);
        
        // Especificamos el fetch mode antes de llamar a fetch()
        $this->query_statement->setFetchMode(PDO::FETCH_ASSOC);

        // Bind parameters
        for ($paramIndex=1; $paramIndex <= count($parameters); $paramIndex++) { 
            $this->query_statement->bindParam($paramIndex,$parameters[$paramIndex]);
        }
        
        // Ejecutamos
        $this->query_statement->execute();
        
        // Mostramos los resultados
        $query_result = array();

        while ($row = $this->query_statement->fetch()){
            $query_result[] = $row; 
        }        

        return $query_result;
    }

    protected function findAll()
    {
        return $this->execute_query("SELECT * FROM {$this->db_table}");
    }
       
    public abstract function parse($source);

    protected abstract function extractCustomProperties($source);

    public abstract function getById();
    public abstract function save();
    public abstract function delete();
    public abstract function update();
}

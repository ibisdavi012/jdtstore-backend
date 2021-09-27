<?php 

namespace App\Models;
use PDO; 
use App\Utils\PropertyParser;
/**
* BaseModel - All models extends this Model.
*
* @author      David Márquez <ibisdavi012@gmail.com>
* @license     MIT
* 
*/

abstract class BaseModel {
   
    protected $db_table;

    protected $errors = array();

    protected $db_connection_handle = null;

    protected $query_statement = null;

    protected $parseable_attributes;

    protected $custom_attributes;

    public function getErrors() {
        return $this->errors;
    }

    protected function logError($source,$description) {
        $this->errors[$source] = $description;
    }
    
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

    public function execute_query($query,$parameters = array()) {
        if(!$this->db_connection_handle) {
            return null;
        }
        $this->query_statement = $this->db_connection_handle->prepare($query);
        
        // Especificamos el fetch mode antes de llamar a fetch()
        $this->query_statement->setFetchMode(PDO::FETCH_ASSOC);

        // Bind parameters
        for ($paramIndex=1; $paramIndex <= count($parameters); $paramIndex++) { 
            $this->query_statement->bindParam($paramIndex,$parameters[$paramIndex - 1]);
        }       

        // Ejecutamos     
        if(!$this->query_statement->execute()){
            $this->logError('DATABASE_QUERY_EXECUTION', $this->query_statement->errorInfo());
            return false;
        }
                     
        // Mostramos los resultados
        $query_result = array();

        while ($row = $this->query_statement->fetch()){
            $query_result[] = $row; 
        }   

        if(strpos($query,'INSERT') !== false){
            return $this->db_connection_handle->lastInsertId();
        }

        if(strpos($query,'DELETE') !== false || strpos($query,'UPDATE') !== false){
            return $this->query_statement->rowCount();
        }

        return $query_result;
    }

    protected function findAll()
    {
        return $this->execute_query("SELECT * FROM {$this->db_table}");
    }

    protected function deleteById($id) {
        return $this->execute_query("DELETE FROM {$this->db_table} WHERE id = $id");
    }

    private function extractAttributes($source,$attributesList) {

        if(is_null($source) || !$source){
            return false;
        }

        foreach ($source as $column => $value) {
            $property = "set" . ucfirst($column);                           
            if(is_array($attributesList) && in_array($column,$attributesList)) {                
                $this->$property($value);
            }
        }
        
    }

    private function parseFromArray($source) {
        
        $this->extractAttributes($source,$this->parseable_attributes);
        
        $customAttributes = json_decode($source['custom_attributes'],true);
        
        $this->extractAttributes($customAttributes,$this->custom_attributes);

    }

    private function parseFromString($source) {
        $attributes = json_decode($source,true);
        $this->extractAttributes($attributes,$this->parseable_attributes);
        $this->extractAttributes($attributes,$this->custom_attributes);        
    }

       
    public function parse($source) {

        if(is_array($source)) {
            $this->parseFromArray($source);
        }
        elseif(is_string($source)) {
            $this->parseFromString($source);
        } else{
            return null;
        }
     
    }

    public function findById($id) {
        $result = $this->execute_query("SELECT * FROM {$this->db_table} WHERE id = $id");
        
        if(count($result)) {   
            
            $type = "App\\Models\\" . ucfirst($result[0]['type']);                
               
            $model = !class_exists($type,true) ? new Product() : new $type();                    
                        
            $model->parse($result[0]);

            return $model->toArray();      

        }

        return null;
    }

    public abstract function toArray();        
    public abstract function save();
    public abstract function delete();
    public abstract function update();
    
   
}

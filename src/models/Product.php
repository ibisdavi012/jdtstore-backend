<?php
namespace App\Models;

class Product extends ProductModel {
    protected $id = null;
    
    protected $sku = '';

    protected $name = '';
    
    protected $price = 0;

    protected $type = 'dvd';

    public function __construct() {
        parent::__construct('eav_products');        
    }

        // ID
        public function setId($id) {
            if (!is_numeric($id)) {
                $this->errors[] = 'Id is invalid';
                return false;
            }
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }
    
        // SKU
        public function setSku($sku) {
            $validSku = preg_match('/^[a-z0-9]{10,20}$/i',$sku);
            
            if (!$validSku) {
                $this->errors['sku'] = 'SKU is not valid. It must be an alphanumeric value between 10 and 20 characters.';
                return false;
            }
            $this->sku = $sku;
            return true;
        }
    
        public function getSku() {

            return $this->sku;
        }
    
        // Name
        public function setName($name) {

            $isValid = true;

            $alphanumeric = preg_match('/^[a-zA-Z0-9\s]{5,15}$/i',$name);
            
            if(!$alphanumeric) {
                $this->errors['name'] = 'Invalid value. It must be an alphanumeric string between 5 and 15 characters.';
                return false;
            }

            $consecutiveSpacing = preg_match('/(\s+){2}/',$name);

            if($consecutiveSpacing) {
                $this->errors['name'] = 'It contains to many blank spaces in a row.';
                return false;
            }
            
            $this->name = $name;
            
            return true;
        }
    
        public function getName() {
            return $this->name;
        }
    
        // Price
        public function setPrice($price) {           

            if(!is_numeric($price)){
                $this->errors['price'] = 'Invalid format. It must be a valid number in the Standard American format. Ex. 1,000.00 / 34.75';
                return false;
            }

            $this->price = (float)$price;
            
            return true;
        }
    
        public function getPrice() {
            return $this->price;
        }
    
        // Type
        public function setType($type) {
            if(!in_array($type,array('dvd','book','furniture'))){
                $this->errors['type'] = 'Type does not exist';
                return false;
            }
            $this->type = $type;
        }
    
        public function getType() {
            return $this->type;
        }
        
    
        public function toArray(){            
            return array(
                'id' => $this->getId(),
                'sku' => $this->getSku(),
                'name' => $this->getName(),
                'price' => $this->getPrice(),
                'type' => $this->getType()                
            );
        }

        protected function setAttribute($attribute,$value,$unit)
        {
            $validValue = preg_match("/^(\d+|\d+\.[\d]{1,2})\s{0,1}[$unit]{0,1}$/i",$value);
        
            if(!$validValue) {         
                $this->errors[$attribute] = "It must be express in $unit. Follow the format: 12$unit / 15 $unit / 25.10$unit / 17.23 $unit";        
                return false;
            }
                       
            $this->{$attribute} = $value;        
    
            return true;
        }
    
    public function save(){ $save_result = $this->execute_query("INSERT INTO products 
        (sku,name, price, type, custom_attributes) 
    VALUES 
        (?,?,?,?)",array(
            $this->getSku(),
            $this->getName(),
            $this->getPrice(),
            $this->getType()
        ));}

    public function delete(){
        if($this->id === null){
            $this->errors['id'] = 'You must specify a valid ID.';
            return false;
        }
        
        return  $this->deleteById($this->getId());        
    }
    public function update(){}
}
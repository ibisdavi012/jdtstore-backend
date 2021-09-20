<?php
namespace App\Models;
use App\Utils\PropertyParser;

class Dvd extends ProductModel {

    protected $size = 0;
       
    public function parse($source){        
        
        $parseable_properties = array('id','sku','name','price','type');

        PropertyParser::parseDefaultProperties($this, $source, $parseable_properties);
        
        $this->extractCustomProperties($source['specifics']);
        
    }

    public function extractCustomProperties($source){
        
        echo '<hr><pr>';
        $customProperties = json_decode(null,true);
        echo 'Size: ' . $customProperties['size'];

        echo '<hr><pre>';
        var_dump($this);
        echo '</pre>';
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getById(){}
    public function save(){}
    public function delete(){}
    public function update(){}
}
<?php
namespace App\Utils;

class PropertyParser {

    public static function parseDefaultProperties($target, $source, $parseable_properties){
        foreach ($source as $column => $value) {
            $property = "set" . ucfirst($column);                           
            if(is_array($parseable_properties) && in_array($column,$parseable_properties)) {
                $target->$property($value);
            }
        }
    }

}
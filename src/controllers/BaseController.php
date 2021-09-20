<?php 

namespace App\Controllers;
use App\Models\BaseModel;

class BaseController {

    public function __call($name,$args) {
        
    }

    public function __construct() {
    }
  
}
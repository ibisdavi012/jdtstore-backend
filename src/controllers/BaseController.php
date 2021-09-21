<?php 

namespace App\Controllers;

abstract class BaseController {

    public function __call($name,$args) {
        $this->send_http_status(404);
    }

    public function send_http_status($status) {
        
        switch($status) {
            case 403:
                header(HTTP403);
                break;
            case 404:
                header(HTTP404);
                break;
            default:
            break;
        }
        
        exit();
    }
   
   
    protected function send_response($reponse,$error=false) {
        
        header_remove('Set-Cookie');
        
        header(HTTP_CORS);  
        
        header(HTTP_JSON);

        echo json_encode(
            array(
                    'status'        => $error ? 'ERROR' : 'OK', 
                    'api_version'   =>'1.0',
                    'content'       => $reponse
            )
        );
    }

    public abstract function GET($id);
    public abstract function POST();
    public abstract function DELETE($id);

}
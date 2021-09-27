<?php 

namespace App\Controllers;

abstract class BaseController {

    public function __call($name,$args) {
        header(HTTP404);
    } 
   
        public function sendHeaders() {
            header(HTTP_CORS);
            header(HTTP_ACEH);
            header(HTTP_ACAH);            
            header(HTTP_ACAM);        
            header(HTTP_JSON);
        }

       protected function send_response($message, $affected_rows, $content,$error=false) {    
        
        $this->sendHeaders();

        echo json_encode(
            array(
                    'status'        => $error ? 'ERROR' : 'OK', 
                    'api_version'   =>'1.0',
                    'message'       => $message,
                    'affected_rows' => $affected_rows,
                    'content'       => $content
            )
        );

        
    }
    
    public function OPTIONS() {        
        $this->sendHeaders();
        header(HTTP200);
    }

    public abstract function GET($id);
    public abstract function POST();
    public abstract function DELETE($id);

}
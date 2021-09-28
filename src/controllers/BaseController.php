<?php

namespace App\Controllers;

/**
 * BaseController - All Controllers will extend this class
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
abstract class BaseController
{

    public function __call($name, $args)
    {
        header(HTTP404);
    }

    /**
     * Send Default HTTP Headers
     *
     * @return void
     */
    public function sendHeaders()
    {
        header(HTTP_CORS);
        header(HTTP_ACEH);
        header(HTTP_ACAH);
        header(HTTP_ACAM);
        header(HTTP_JSON);
    }

    /**
     * It sends the respone in JSON format.
     *
     * @param  string $message
     * @param  int $affected_rows
     * @param  array $content
     * @param  bool $error
     * @return void
     */
    protected function sendResponse($message, $affected_rows, $content, $error = false)
    {

        $this->sendHeaders();

        echo json_encode(
            array(
                'status'        => $error ? 'ERROR' : 'OK',
                'api_version'   => '1.0',
                'message'       => $message,
                'affected_rows' => $affected_rows,
                'content'       => $content
            )
        );

        exit;
    }


    /**
     * Handle OPTIONS REQUEST      *
     * @return void
     */
    public function options()
    {
        $this->sendHeaders();
        header(HTTP200);
    }

    abstract public function get($id);
    abstract public function post();
    abstract public function delete($id);
}

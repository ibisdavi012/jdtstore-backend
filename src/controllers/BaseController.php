<?php

namespace App\controllers;

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
        header("Access-Control-Allow-Origin: https://frosty-darwin-651925.netlify.app");
        header("Access-Control-Allow-Headers: GET, POST, DELETE, OPTIONS");
        header('Content-Type: application/json; charset=utf-8');
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
        exit;
    }

    abstract public function get($id);
    abstract public function post();
    abstract public function delete($id);
}

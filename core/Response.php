<?php

/**
 * Response.php.
 * User: kzoltan
 * Date: 2022. 02. 24.
 * Time: 14:09
 */

namespace app\core;

/**
 * Description of Response
 * @package app\core
 * @author kzoltan
 */
class Response {
    
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header('Location: '.$url);
    }

}

<?php

/**
 * _error.php.
 * User: kzoltan
 * Date: 2022-03-03
 * Time: 07:31
 */

namespace app\core\exception;

/**
 * Description of NotFoundException
 *
 * @author kzoltan
 * @package app\core\exception
 */
class NotFoundException extends \Exception
{
    protected $message = 'Page not found'; 
    protected $code = 404;
    
}

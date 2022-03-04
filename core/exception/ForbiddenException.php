<?php

/**
 * _error.php.
 * User: kzoltan
 * Date: 2022-03-03
 * Time: 07:31
 */

namespace app\core\exception;

/**
 * Description of ForbiddenException
 *
 * @author kzoltan
 * @package app\core\exception
 */
class ForbiddenException extends \Exception 
{
    protected $message = 'You don`t have permission to access this page';
    protected $code = 403;
}

<?php

/**
 * BaseMiddleware.php.
 * User: kzoltan
 * Date: 2022-03-02
 * Time: 17:06
 */

namespace app\core\middlewares;

/**
 * Description of BaseMiddleware
 *
 * @author Selester
 */
abstract class BaseMiddleware 
{
    abstract public function execute();
}

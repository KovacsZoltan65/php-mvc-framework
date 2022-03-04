<?php

/**
 * AuthMiddleware.php.
 * User: kzoltan
 * Date: 2022-03-02
 * Time: 17:06
 */

namespace app\core\middlewares;

use app\core\middlewares\BaseMiddleware;
use app\core\Application;
use app\core\exception\ForbiddenException;

/**
 * Description of AuthMiddleware
 *
 * @author Selester
 */
class AuthMiddleware extends BaseMiddleware 
{
    public array $actions = [];
    
    public function __construct(array $actions = []) {
        $this->actions = $actions;
    }
    
    public function execute() 
    {
        if(Application::isGuest())
        {
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))
            {
                throw new ForbiddenException();
            }
        }
    }

}

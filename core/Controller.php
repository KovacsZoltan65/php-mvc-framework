<?php

/**
 * Controller.php.
 * User: kzoltan
 * Date: 2022-02-24
 * Time: 14:09
 */

namespace app\core;

use app\core\middlewares\BaseMiddleware;

/**
 * Description of Controller
 *
 * @author kzoltan
 */
class Controller 
{
    public string $layout = 'main';
    public string $action = '';
    
    /**
     * 
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];
    
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }
    
    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
    
    /**
     * 
     * @return \app\core\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}

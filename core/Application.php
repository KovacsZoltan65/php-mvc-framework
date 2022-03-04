<?php
/**
 * Application.php.
 * User: kzoltan
 * Date: 2022-02-24
 * Time: 14:09
 */

namespace app\core;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\Application;
use app\core\Router;
use app\core\db\DbModel;
use app\core\db\Database;
use app\core\Session;
use app\core\View;
//use app\models\User;

/**
 * Class Application
 * @package app\core
 * @author kzoltan
 */
class Application 
{
    public string $layout = 'main';
    public static string $ROOT_DIR;
    public string $user_class;
	public Router $router;
	public Request $request;
    public Response $response;
    public Database $db;
    public ?UserModel $user;
    public Session $session;
    public static Application $app;
    public ?Controller $controller = null;
    public View $view;

	/**
	 * Application constructor.
	 */
	public function __construct($rootPath, array $config)
	{
        $this->user_class = $config['user_class'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
		$this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
		$this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);
        
        $primary_value = $this->session->get('user');
        if($primary_value)
        {
            $primary_key = $this->user_class::primaryKey();
            $this->user = $this->user_class::findOne([$primary_key => $primary_value]);
        }
        else
        {
            $this->user = null;
        }
	}

	/**
	 * @return Router
	 */
	public function run() : void
	{
		try 
        {
            echo $this->router->resolve();
        } 
        catch (\Exception $e) 
        {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e,
            ]);
        }
    }

    public function getController() : Controller
    {
        return $this->controller;
    }
    
    public function setController(Controller $controller) : void
    {
        $this->controller = $controller;
    }
    
    public function login(UserModel $user)
    {
        $this->user = $user;
        $primary_key = $user->primaryKey();
        $primary_value = $user->{$primary_key};
        $this->session->set('user', $primary_value);
        return true;
    }
    
    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
    
    public function isGuest()
    {
        return !self::$app->user;
    }
}
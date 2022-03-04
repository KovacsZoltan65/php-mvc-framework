<?php

/**
 * Session.php
 * User: kzoltan
 * Date: 2022-03-01
 * Time: 14:25
 */

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\core\Application;
use app\models\LoginForm;
use app\core\middlewares\AuthMiddleware;

/**
 * Description of AuthController
 *
 * @author Selester
 */
class AuthController extends Controller 
{
    
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    
    public function login(Request $request, Response $response)
    {
        $login_form = new LoginForm();
        
        if($request->isPost()){
            $login_form->loadData($request->getBody());
            if($login_form->validate() && $login_form->login())
            {
                $response->redirect('/');
                return;
            }
        }
        
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $login_form,
        ]);
    }
    
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
    
    public function register(Request $request)
    {
        $errors = [];
        $user = new User();
        
        if($request->isPost())
        {    
            $user->loadData($request->getBody());
            
            if($user->validate() && $user->save())
            {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                exit;
            }
            
            return $this->render('register', [
                'model' => $user,
            ]);
        }
        $this->setLayout('auth');
        
        return $this->render('register', [
            'model' => $user,
        ]);
    }
    
    public function profile()
    {
        return $this->render('profile');
    }
    
}
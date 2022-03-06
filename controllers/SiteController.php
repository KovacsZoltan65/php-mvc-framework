<?php

/**
 * SiteController.php.
 * User: kzoltan
 * Date: 2022. 02. 24.
 * Time: 14:09
 */
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

/**
 * Description of SiteController
 *
 * @author kzoltan
 * @package app\controllers
 */
class SiteController extends Controller 
{
    public function home()
    {
        $params = [
            'name' => 'TheCodeHolic'
        ];
        return $this->render('home', $params);
    }
    
    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        
        if($request->isPost())
        {
            $contact->loadData($request->getBody());
            if($contact->validate() && $contact->send())
            {
                Application::$app->session->setFlash('success', 'Thanks for contacting us');
                return $response->redirect('/contact');
            }
            
        }
        
        return $this->render('contact', [
            'model' => $contact
        ]);
        
    }
}

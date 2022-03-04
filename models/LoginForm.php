<?php

/**
 * LoginForm.php
 * User: kzoltan
 * Date: 2022-03-01
 * Time: 17:59
 */

namespace app\models;

use app\core\Model;
use app\models\User;
use app\core\Application;

/**
 * Description of LoginForm
 *
 * @author Selester
 */
class LoginForm extends Model
{
    public string $email = '',
        $password = '';
    
    public function rules(): array 
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function labels() : array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
    
    public function login()
    {
        $user = User::findOne(['email' => $this->email]);
        if(!$user)
        {
            $this->addError('email', 'User does not exist with this email');
            return false;
        }
        if(!password_verify($this->password, $user->password))
        {
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        
        return Application::$app->login($user);
    }
    
}

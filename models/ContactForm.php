<?php

/**
 * ContactForm.php
 * User: kzoltan
 * Date: 2022-03-03
 * Time: 16:40
 */

namespace app\models;

use app\core\Model;

/**
 * Description of ContactForm
 *
 * @author kzoltan
 */
class ContactForm extends Model
{
    public string $subject = '', 
        $email = '', 
        $body = '';
    
    //put your code here
    public function rules(): array 
    {
        return [
            'subject' => self::RULE_REQUIRED,
            'email' => self::RULE_REQUIRED,
            'body' => self::RULE_REQUIRED,
        ];
    }
    
    public function labels() : array
    {
        return [
            'subject' => 'Enter your subject',
            'email' => 'Your email',
            'body' => 'Body',
        ];
    }
    
    public function send()
    {
        return true;
    }

}

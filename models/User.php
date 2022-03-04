<?php

/**
 * RegisterModel.php
 * User: kzoltan
 * Date: 2022-02-25
 * Time: 7:46
 */

namespace app\models;

use app\core\UserModel;

/**
 * Description of RegisterModel
 *
 * @author Selester
 */
class User extends UserModel
{
    const STATUS_INACTIVE = 0,
        STATUS_ACTIVE = 1,
        STATUS_DELETED = 2;
    
    public string $first_name = '', 
        $last_name = '', 
        $email = '', 
        $password = '', 
        $confirm_password = '';
    public int $status = self::STATUS_INACTIVE;
    
    public function tableName(): string 
    {
        return 'users';
    }
    
    public function primaryKey(): string
    {
        return 'id';
    }
    
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        
        return parent::save();
    }

    public function rules(): array 
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class, 'attribute' => 'email'
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24] ],
            'confirm_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function attributes(): array 
    {
        return ['first_name', 'last_name', 'email', 'password', 'status'];
    }

    public function labels() : array 
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
        ];
    }

    public function getDisplayName(): string 
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}

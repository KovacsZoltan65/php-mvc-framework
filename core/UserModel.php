<?php

/**
 * UserModel.php
 * User: kzoltan
 * Date: 2022-03-02
 * Time: 16:11
 */

namespace app\core;

use app\core\db\DbModel;

/**
 * Description of UserModel
 * @package app\core
 * @author kzoltan
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}

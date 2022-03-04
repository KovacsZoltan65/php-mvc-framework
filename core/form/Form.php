<?php

/**
 * Form.php
 * User: kzoltan
 * Date: 2022-02-25
 * Time: 07:46
 */

namespace app\core\form;

use app\core\Model;
use app\core\form\InputField;

/**
 * Description of Form
 *
 * @author Selester
 */
class Form 
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    
    public static function end()
    {
        echo '</form>';
    }
    
    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}

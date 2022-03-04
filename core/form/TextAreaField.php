<?php

/**
 * TextAreaField.php
 * User: kzoltan
 * Date: 2022-03-04
 * Time: 07:55
 */

namespace app\core\form;

use app\core\form\BaseField;

/**
 * Description of TextAreaField
 *
 * @author kzoltan
 */
class TextAreaField extends BaseField
{
    //put your code here
    public function renderInput(): string 
    {
        return sprintf('<textarea id="%s" name="%s" class="form-control%s">%s</textarea>', 
            $this->attribute, $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute}
        );
    }

}

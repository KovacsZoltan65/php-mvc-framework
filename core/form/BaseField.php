<?php

/**
 * BaseField.php.
 * User: kzoltan
 * Date: 2022-03-03
 * Time: 17:00
 */

namespace app\core\form;

use app\core\Model;

/**
 * Description of BaseField
 *
 * @author kzoltan
 */
abstract class BaseField 
{
    public Model $model;
    public string $attribute;
    
    
    public function __construct(Model $model, string $attribute) 
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    
    abstract public function renderInput() : string;
    
    public function __toString() 
    {
        return sprintf('
            <div class="form-group">
                <label for="%s" 
                       class="form-label">%s</label>
                ' . $this->renderInput() . '
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
            ', 
            $this->attribute, // for="%s"
            $this->model->getLabel($this->attribute), // >%s</label>
            $this->model->getFirstError($this->attribute) // invalid-feedback
        );
    }
    
}

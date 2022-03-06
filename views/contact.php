<?php

/** 
 * @package app\views
 * @author kzoltan
 * @var $this \app\core\View 
 * @var $model \app\models\ContactForm
 */

use app\core\form\TextAreaField;
use app\core\form\Form;

$this->title = 'Contact';
?>
<h1>Contact</h1>

<?php $form = Form::begin('', 'post') ?>
<?php echo $form->field($model, 'subject') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo new TextAreaField($model, 'body') ?>

<button type="submit" class="btn btn-primary">Submit</button>

<?php Form::end() ?>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Register';

$form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <?= $form->field($model, 'role')->dropDownList(['admin' => 'Admin', 'user' => 'User', 'manager' => 'Manager']) ?>

    <div class="form-group">
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="site-signup">

    <?php $form = ActiveForm::begin([
      'options' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
      ],
      'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-2\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-2 control-label'],
      ],
    ]); ?>

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        <?= $form->field($model, 'type')->radioList($model->typeList()) ?>
        <div class="form-group">
          <label class="col-lg-2 control-label"></label>
          <div class="col-lg-4">
            <?= Html::submitButton(Yii::t('app', 'SignUp'), ['class' => 'btn btn-primary']) ?>
          </div>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-signup -->

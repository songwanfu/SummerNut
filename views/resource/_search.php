<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ResourceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resource-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'icon') ?>

    <?= $form->field($model, 'extension') ?>

    <?= $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'resource_type') ?>

    <?php // echo $form->field($model, 'course_id') ?>

    <?php // echo $form->field($model, 'play_count') ?>

    <?php // echo $form->field($model, 'download_count') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

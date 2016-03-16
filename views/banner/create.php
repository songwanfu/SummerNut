<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\Banner */

$this->title = Yii::t('app', 'Create Banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

	<div class="banner-form">

	    <?php $form = ActiveForm::begin([
	        'options' => [
	            'class' => 'form-horizontal',
	            'enctype' => 'multipart/form-data',
	        ],
	        'fieldConfig' => [
	            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
	            'labelOptions' => ['class' => 'col-lg-1 control-label'],
	        ],
		]); ?>

	    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'img')->fileInput(['accept' => 'image/*']) ?>

	    <?= $form->field($model, 'jump_target')->textInput(['maxlength' => true]) ?>

	    <div class="form-group">
	    	<label class="col-lg-1 control-label"></label>
	    	<div class="col-lg-3">
	        	<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    	</div>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>

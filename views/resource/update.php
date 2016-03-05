<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Resource;
/* @var $this yii\web\View */
/* @var $model app\models\Resource */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Resource',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Resources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="resource-update">

	<div class="resource-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'status')->dropDownList(Resource::statusList()) ?>

	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>

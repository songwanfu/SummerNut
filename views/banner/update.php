<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\Banner */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Banner',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="banner-update">

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

	    <div class="form-group">
	        <label class="col-lg-1 control-label">图片</label>
	        <div class="col-lg-6">
	            <img src="<?= $model->img ?>" alt="" style="width:370px;heigth:100px">
	        </div>
	        <div class="col-lg-5"><div class="help-block"></div></div>
	     </div> 

	    <div class="form-group">
	        <label class="col-lg-1 control-label"></label>
	        <div class="col-lg-6">
	            <input type="hidden" id='img' name="Banner[img]" value="<?php echo $model['img']?>">
	            <input type="file" accept="image/png,image/jpg,image/jpeg,image/gif" id="img" name="Banner[img]" value="<?php echo $model['img'] ?>" onchange="document.getElementById('img').value=getPath(this);">
	        </div>
	    </div>

	    <?= $form->field($model, 'jump_target')->textInput(['maxlength' => true]) ?>

	    <div class="form-group">
	    	<label class="col-lg-1 control-label"></label>
        	<div class="col-lg-5">
	        	<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    	</div>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>

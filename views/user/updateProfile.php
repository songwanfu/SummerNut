<?php
use yii\helpers\Url;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
$form = ActiveForm::begin();
?>

	<div class="row col-lg-6 user-profile">

		<div class="input-group">
		  <span class="input-group-addon" id="sizing-addon"><span class="fa fa-user"></span></span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon" value="<?php echo $model->username;?>">
		</div>

		<div class="input-group">
		  <span class="input-group-addon" id="sizing-addon"><span class="fa fa-at"></span></span>
		  <input type="text" class="form-control" placeholder="Email" aria-describedby="sizing-addon" value="<?php echo $model->email;?>">
		</div>

		<div class="input-group">
		  <span class="input-group-addon" id="sizing-addon"><span class="fa fa-pencil-square"></span></span>
		  <input type="text" class="form-control" placeholder="Signature" aria-describedby="sizing-addon" value="<?php echo $model->signature;?>">
		</div>

		<div class="user-sex">
		<?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'sex', ['labelOptions' => ['class' => 'radio-inline']])->radioList(['1' => 'nan', '2' => 'nv'] )?>
<!-- 			<label>性别</label>
			<label class="radio-inline">
			  <input type="radio" name="sex-venus" id="sex-venus" value="1"> <span class="fa fa-venus"></span>
			</label>
			<label class="radio-inline">
			  <input type="radio" name="sex-mars" id="sex-mars" value="2"> <span class="fa fa-mars"></span>
			</label> -->
			
		</div>
		
		<div class="user-head-pic">
			<label>头像</label>
			<img src="<?php echo $model->head_picture;?>" class="img-circle">
		</div>
		<div class="col-lg-12 upload-head-pic">
			<?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
        ],
	    ]); ?>

			<?= $form->field($model, 'head_picture')->label(Yii::t('app', 'Upload Head Picture'))->widget(FileInput::classname(), [
		    'pluginOptions' => [
		        'uploadUrl' => Url::to(['/user/upload-head-pic']),
		        'uploadAsync' => false,
		        'allowedPreviewTypes' => ['image'],
		        'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
		        'maxFileCount' => 1,
		        'maxFileSize' => 1000,
		        'uploadExtraData' => [
		            '_csrf' => Yii::$app->request->csrfToken,
		            'User[id]' => $model->id,
		        ] 
		    ]
	   		]); ?>

	   	<?php ActiveForm::end(); ?>
   	</div>
		
		
	</div>
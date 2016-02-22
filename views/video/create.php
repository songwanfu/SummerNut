
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = Yii::t('app', 'Create Video');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="video-create">

    <div class="video-form">
	    <?php $form = ActiveForm::begin([
	    	'options' => [
	            'class' => 'form-horizontal',
	            'enctype' => 'multipart/form-data',
	        ],
	    ]); ?>
		
	   	<?= $form->field($model, 'url')->label(Yii::t('app', 'Create Video'))->widget(FileInput::classname(), [
	    	'pluginOptions' => [
		        'uploadUrl' => Url::to(['video/upload']),
		        'uploadAsync' => false,
		        'allowedPreviewTypes' => ['video'],
		        'allowedFileExtensions' => ['mp4','flv', 'avi', 'wmv', 'rmvb'],
		        'maxFileCount' => 1,
		       	'maxFileSize' => 100000,
		        'uploadExtraData' => [
		            '_csrf' => Yii::$app->request->csrfToken,
		        ]
		        
    		]
    	]); ?>

	    <?php ActiveForm::end(); ?>

	</div>

</div>


<script type="text/javascript">

	
	// var obj = document.getElementById('uploadVideo')
	// $('#uploadVideo').on('filebatchuploadcomplete', function(event, files, extra) {
	//     console.log('upload end');
	// });


</script>

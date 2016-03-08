<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\markdown\MarkdownEditor;
use app\models\Task;
/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = Yii::t('app', 'Update Task');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$taskName = mb_substr(strip_tags($model->title), 0, 60);
$taskName .= '......';
$this->params['breadcrumbs'][] = ['label' => $taskName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="task-update">

	<div class="task-form">

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

	    <?= $form->field($model, 'course_id')->textInput() ?>

	    <?= $form->field($model, 'task_type')->dropdownList(Task::typeList(), ['disabled' => 'true']) ?>

	    <?= $form->field($model, 'title')->widget(MarkdownEditor::classname(), ['height' => 260, 'encodeLabels' => true, 'smarty' => true, 'previewAction' => Url::to(['task/preview']),]); ?>

	    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>
		
		<?= $form->field($model, 'answer_json')->widget(MarkdownEditor::classname(), ['height' => 260, 'encodeLabels' => true, 'smarty' => true, 'previewAction' => Url::to(['task/preview']),]); ?>

	    <?= $form->field($model, 'score')->dropdownList(Task::scoreList()) ?>

	    <?= $form->field($model, 'is_timing')->dropdownList(Task::timingList()) ?>

		<span id="complete_time">
	    	<?= $form->field($model, 'complete_time')->dropdownList(Task::timeList()) ?>
		</span>
	    <div class="form-group">
	    	<label class="col-lg-2 control-label"></label>
	    	<div class="col-lg-4">
	        	<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    	</div>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>

<script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.2.0/jquery.js"></script>
<script type="text/javascript">
	var IS_TIMING = 1;
	var IS_NOT_TIMING =0;

	$('#task-is_timing').change(function(){
		var type = $(this).children('option:selected').val();
		if (type == IS_TIMING) {
			$('#complete_time').show();
		} else {
			$('#complete_time').hide();
		}
		
	});
</script>

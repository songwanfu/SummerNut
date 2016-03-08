<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Task;
use app\models\Course;
use kartik\markdown\MarkdownEditor;
// use \Michelf\Markdown, \Michelf\SmartyPants;
/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = Yii::t('app', 'Create Task');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
if (!empty($courseName)) {
    $this->params['breadcrumbs'][] = $courseName;
    $this->params['breadcrumbs'][] = $chapterName;
}
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="task-create">

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

	    <?= $form->field($model, 'course_id')->dropdownList(ArrayHelper::map(Course::fileMap(['id', 'name']), 'id', 'name')) ?>

	    <?= $form->field($model, 'task_type')->dropdownList(Task::typeList()) ?>

	    <?= $form->field($model, 'title')->widget(MarkdownEditor::classname(), ['height' => 260, 'encodeLabels' => true, 'smarty' => true, 'previewAction' => Url::to(['task/preview']),]); ?>

		<span id="choice-a" style="display: none">
			<?= $form->field($model, 'option_A')->textInput(['maxlength' => true]) ?>
		</span>
		
		<span id="choice-b" style="display: none">
			<?= $form->field($model, 'option_B')->textInput(['maxlength' => true]) ?>
		</span>
		
		<span id="choice-c" style="display: none">
			<?= $form->field($model, 'option_C')->textInput(['maxlength' => true]) ?>
		</span>

		<span id="choice-d" style="display: none">
			<?= $form->field($model, 'option_D')->textInput(['maxlength' => true]) ?>
		</span>
		
		<span id="answer_json" style="display: none">
			<?= $form->field($model, 'answer_json')->widget(MarkdownEditor::classname(), ['height' => 260, 'encodeLabels' => true, 'smarty' => true, 'previewAction' => Url::to(['task/preview']),]); ?>
		</span>

		<span id="answer_choice" style="display: none">
	    	<?= $form->field($model, 'answer_choice')->checkboxList($model::answerList()) ?>
		</span>

	    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

	    <?= $form->field($model, 'score')->dropdownList(Task::scoreList()) ?>

	    <?= $form->field($model, 'is_timing')->dropdownList(Task::timingList()) ?>
		
		<span id="complete_time" style="display: none">
	    	<?= $form->field($model, 'complete_time')->dropdownList(Task::timeList()) ?>
		</span>
		

		<span id='code_test_one_input' style="display: none">
			<?= $form->field($model, 'code_test_one_input')->textInput(['maxlength' => true]) ?>
		</span>

		
		<span id='code_test_one_output' style="display: none">
			<?= $form->field($model, 'code_test_one_output')->textInput(['maxlength' => true]) ?>
		</span>

		<span id='code_test_two_input' style="display: none">
			<?= $form->field($model, 'code_test_two_input')->textInput(['maxlength' => true]) ?>
		</span>
		
		<span id='code_test_two_output' style="display: none">
			<?= $form->field($model, 'code_test_two_output')->textInput(['maxlength' => true]) ?>
		</span>

		<span id='code_test_three_input' style="display: none">
			<?= $form->field($model, 'code_test_three_input')->textInput(['maxlength' => true]) ?>
		</span>

		<span id='code_test_three_output' style="display: none">
			<?= $form->field($model, 'code_test_three_output')->textInput(['maxlength' => true]) ?>
		</span>
	


	    <?php //echo $form->field($model, 'option_json')->widget(MarkdownEditor::classname(), ['height' => 260, 'encodeLabels' => true, 'smarty' => true, 'previewAction' => Url::to(['task/preview']),]); ?>

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

	var TYPE_CHOICE = 1;
	var TYPE_SHORT_ANSWER = 2;
	var TYPE_CALCULATION = 3;
	var TYPE_CODING = 4;
	var IS_TIMING = 1;
	var IS_NOT_TIMING =0;

	taskInit();

	$('#task-task_type').change(function(){
		var type = $(this).children('option:selected').val();
		if (type == TYPE_CHOICE) {
			choiceOpen();
			$('#answer_json').hide();
		} else if (type == TYPE_CODING) {
			choiceClose();
			codeOpen();
			$('#answer_json').hide();
		} else {
			choiceClose();
			codeClose();
			$('#answer_json').show();
		}
		
	});

	function taskInit()
	{
		if (TYPE_CHOICE == $('#task-task_type').children('option:selected').val()) {
			choiceOpen();
		} else {
			choiceClose();
			$('#answer_json').show();
		}
	}

	function choiceOpen()
	{
		$('#choice-a').show();
		$('#choice-b').show();
		$('#choice-c').show();
		$('#choice-d').show();
		$('#answer_choice').show();
	}

	function choiceClose()
	{
		$('#choice-a').hide();
		$('#choice-b').hide();
		$('#choice-c').hide();
		$('#choice-d').hide();
		$('#answer_choice').hide();
	}

	function codeOpen()
	{
		$('#code_test_one_input').show();
		$('#code_test_two_input').show();
		$('#code_test_three_input').show();
		$('#code_test_one_output').show();
		$('#code_test_two_output').show();
		$('#code_test_three_output').show();
	}

	function codeClose()
	{
		$('#code_test_one_input').hide();
		$('#code_test_two_input').hide();
		$('#code_test_three_input').hide();
		$('#code_test_one_output').hide();
		$('#code_test_two_output').hide();
		$('#code_test_three_output').hide();
	}

	$('#task-is_timing').change(function(){
		var type = $(this).children('option:selected').val();

		if (type == IS_TIMING) {
			$('#complete_time').show();
		} else {
			$('#complete_time').hide();
		}
		
	});

</script>

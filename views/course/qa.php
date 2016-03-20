<?php
use yii\widgets\LinkPager;
use kartik\markdown\MarkdownEditor;
use kartik\markdown\Markdown;
use app\models\Question;
use app\models\Common;
use app\models\User;
use app\models\Answer;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'QA');

?>

<div class="wrap">
	<div class="row course-view-infos">
		<?= $this->render('course-top', ['course' => $course, 'categoryModel' => $categoryModel])?>
	</div>

	<div class="row learn-body">
		<div class="col-lg-9 col-md-9 col-sm-9 course-learn-body">
			<div class="learn-progress progress">
				<?php if ($learnPersent == 0): ?>
					<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
				    <span >已学<?php echo $learnPersent . '%'?> 用时 <?php echo $learnTimeToal?></span>
				  </div>
				<?php else: ?>
				  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $learnPersent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $learnPersent?>%;">
				    <span >已学<?php echo $learnPersent . '%'?> 用时 <?php echo $learnTimeToal?></span>
				  </div>
			  <?php endif ?>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 course-menu">
				<ul class="list-inline">
				  <li class="col-lg-4 col-md-4 col-sm-4"><a href="/course/learn?cid=<?php echo $course->id;?>"><h4><?php echo Yii::t('app', 'Chapter')?></h4></li></a>
				  <li class="col-lg-4 col-md-4 col-sm-4"><a href="/course/comment?cid=<?php echo $course->id;?>"><h4><?php echo Yii::t('app', 'Comments')?></h4></a></li>
				  <li class="col-lg-4 col-md-4 col-sm-4 menu-active"><a href="/course/qa?cid=<?php echo $course->id;?>"><h4><?php echo Yii::t('app', 'QA')?></h4></a></li>
				</ul>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 course-qa">
				<div class="qa-input">
					<?php
						echo MarkdownEditor::widget([
						    'name' => 'markdown', 
						    'options' => ['placeholder' => '求大神！', 'id' => 'input-question'],
						    'height' => 150,
						]);
					?>
					<button class="btn btn-info qa-add-question-btn" onclick="addQuestion(<?php echo $course->id?>)">求答</button>
				</div>

				<div class="qa-detail col-lg-12 col-md-12 col-sm-12">
					<?php foreach (Question::getQuestionList($course->id) as $question): ?>
						<div class="media col-lg-12 col-md-12 col-sm-12">
						  <div class="media-left media-middle col-lg-2 col-md-2 col-sm-2">
						    <a href="#">
						      <img class="media-object img-circle" style="margin: 6% 0 0 0 " src="<?php echo User::findModel($question->user_id)->head_picture?>" alt="" width="60px">
						    </a>
						    <span class="qa-name" style="text-align: center"><?php echo User::findModel($question->user_id)->username?></span>
						  </div>
						  <div class="media-body">
						  	<span class="fa fa-question-circle fa-lg col-lg-1 col-md-1 col-sm-1 qa-question-fa"></span>
						    <span class="media-heading qa-content" ><?php echo Markdown::convert($question->content)?></span>
						    <div class="qa-new">
						    	<span class="fa fa-comment fa-lg col-lg-1 col-md-1 col-sm-1"></span>
						    	<?php if (Answer::replyLatest($question->id)): ?>
						    		<span>[最新回答]</span>
						    		<span><a href=""><?php echo User::findModel(Answer::replyLatest($question->id)->answer_user_id)->username?> :</a></span>
						    		<span><?php echo Answer::replyLatest($question->id)->content?></span>
						    	<?php else: ?>
						    		<span>[还没有人回答]</span>
						    	<?php endif ?>
						    	
						    </div>
						    <span class="evaluation-time col-lg-4 col-md-4 col-sm-4">时间：<?php echo Common::getAwayTime($question->create_time)?></span>
						    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-comments comment-down"><?php echo count(Answer::replyList($question->id))?></span></a>
						    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-eye comment-up"><?php echo $question->views?></span></a>
						  </div>
						</div>
					<?php endforeach ?>
				</div>

			</div>

	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 course-view-right">
		<?= $this->render('course-right', ['isLearn' => true, 'course' => $course])?>
	</div>


</div>

<script type="text/javascript">
	function addQuestion(courseId)
	{
		var content = $('#input-question').val();
		if (content != '') {
			$.ajax({
				url: '/question/add-question',
				type: 'post',
				dataType: 'json',
				data: {
					courseId: courseId,
					content: content,
				},
				success: function (json) {
					window.location.reload();
				},
				error: function () {
					alert('lianjiehsibai');
				}
			});
		}
	}
</script>
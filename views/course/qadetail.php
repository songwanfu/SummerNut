<?php
use yii\widgets\LinkPager;
use kartik\markdown\MarkdownEditor;
use kartik\markdown\Markdown;
use app\models\Question;
use app\models\Common;
use app\models\User;
use app\models\Course;
use app\models\Answer;
/* @var $this yii\web\View */

$this->title = Yii::t('app', $question->content);

$replyList = Answer::replyList($question->id);
?>

<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 qadetail-wrap">
		<div class="col-lg-8 col-md-8 col-sm-8 qadetail-user-info">
			<a href='#'><img src="<?php echo $user->head_picture?>" class="img-circle" width="80px"></a>
			<?php echo $user->username?>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 qadetail-title">
			<?php echo Markdown::convert($question->content)?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 qadetail-bar">
			<div class="col-lg-2 col-md-2 col-sm-2">
				<span><?php echo Common::getAwayTime($question->create_time)?></span>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4">
				<span>源自：<?php echo $course->name?></span>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2" style="float:right">
				<span><?php echo count($replyList)?>回答</span>
				<span><?php echo $question->views?>浏览</span>
			</div>
		</div>
		
		<?php foreach ($replyList as $reply): ?>
		<div class="col-lg-12 col-md-12 col-sm-12 qadetail-reply">
			
				<div class="col-lg-2 col-md-2 col-sm-2 reply-user-info">
					<div  style="margin: 0 25%"><a href='#'><img src="<?php echo User::findModel($reply->answer_user_id)->head_picture?>" class="img-circle" width="60px"></a></div>
					<div class="reply-user-info-name"><?php echo User::findModel($reply->answer_user_id)->username?></div>
				</div>
				<div class="col-lg-3 col-md-2 col-sm-2">
					<?php if ($user->id != $reply->answered_user_id): ?>
						<span style="color: rgba(102,102,102,0.5)">[<?php echo User::findModel($reply->answer_user_id)->username?>回复<?php echo User::findModel($reply->answered_user_id)->username?>]</span>
					<?php endif ?>
				</div>
				<div class="col-lg-10 col-md-10 col-sm-10">
					<?php echo Markdown::convert($reply->content)?>
				</div>
				<div class="col-lg-10 col-md-10 col-sm-10">
					<div class="col-lg-4 col-md-4 col-sm-4">
						<?php echo Common::getAwayTime($reply->create_time)?>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2" style="float:right">
						<?php if ($reply->answer_user_id != Yii::$app->user->id): ?>
							<span class="fa fa-reply" onclick="changeAnsweredName(<?php echo $reply->answer_user_id?>)">回复</span>
	
						<?php endif ?>
					</div>
				</div>
			
			
		</div>
		<?php endforeach ?>

		<div class="col-lg-12 col-md-12 col-sm-12 qadetail-input">
			<?php
				echo MarkdownEditor::widget([
			    'name' => 'markdown', 
			    'options' => ['placeholder' => '求大神！', 'id' => 'input-reply'],
			    'height' => 150,
				]);
			?>
			<button class="btn btn-info reply-btn" onclick="addAnswer(<?php echo $question->id?>)"><?php echo Yii::t('app', 'Reply')?></button>
		</div>

	</div>
</div>

<input type="hidden" value="<?php echo $user->id?>" id="answered-user-id"/>

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript">

	function changeAnsweredName(answerUserId)
	{
		$('#answered-user-id').val(answerUserId);
	}

	function addAnswer(questionId)
	{
		var content = $('#input-reply').val();
		if (content != '') {
			var answeredUserId = $('#answered-user-id').val();
			$.ajax({
				url: '/answer/add-answer',
				type: 'post',
				dataType: 'json',
				data: {
					questionId: questionId,
					content: content,
					answeredUserId: answeredUserId,
				},
				success: function (json) {
					window.location.reload();
				},
				error: function () {
					alert('失败');
				}
				
			});
		}
	}
</script>

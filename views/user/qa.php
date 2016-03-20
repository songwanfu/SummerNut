<?php 
use app\models\Question;
use kartik\markdown\Markdown;
use app\models\Answer;
use app\models\Common;
use app\models\User;
?>
<link rel="stylesheet" type="text/css" href="/css/user-qa.css">

	<div class="row col-lg-10 col-md-10 col-sm-10 user-qa">
		<div id="tabs" class="tabs">
			<nav>
				<ul>
					<li><a href="#section-ask" class="fa fa-question"><span>我的提问</span></a></li>
					<li><a href="#section-reply" class="fa fa-reply"><span>我的回答</span></a></li>
					<li><a href="#section-focus" class="fa fa-eye"><span>我的关注</span></a></li>
				</ul>
			</nav>
			<div class="content">
				<section id="section-ask">
					<?php if (Question::myQuestion($user->id) ): ?>
						<?php foreach (Question::myQuestion($user->id) as $question): ?>
							<div class="panel panel-default">
							  <div class="panel-heading">
							    <h3 class="panel-title"><?php echo Markdown::convert($question->content)?></h3>
							    <span style="font-size: 12px;color: gray;float: right;margin-top: -10px"><?php echo Common::getAwayTime($question->create_time)?></span>
							  </div>
							  <div class="panel-body">
							    <span>[最新回答] <?php echo Answer::replyLatest($question->id)->content?></span>
							    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-comments comment-down"><?php echo count(Answer::replyList($question->id))?></span></a>
							    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-eye comment-up"><?php echo $question->views?></span></a>
							  </div>
							</div>
						<?php endforeach ?>
					<?php else: ?>
					  <div class="alert alert-warning" role="alert"><?php echo Yii::t('app', 'No more questions.');?></div>
					<?php endif ?>
					
				</section>
				<section id="section-reply">
					<?php if (Answer::myReplyList($user->id)): ?>
						<?php foreach (Answer::myReplyList($user->id) as $reply): ?>
						  <div class="alert alert-success" role="alert">
						  	<span>[回复<a href="#"><?php echo User::findModel($reply->answered_user_id)->username?>]</a>:<?php echo $reply->content?></span>
						  	<a href="/course/qadetail?qid=<?php echo $reply->question_id?>"><span class="fa fa-eye" style="float: right;margin-left: 5px"></span></a>
						  	<span class="zone-reply-time"><?php echo Common::getAwayTime($reply->create_time)?></span>
						  </div>
						<?php endforeach ?>
					<?php else: ?>
						<div class="alert alert-warning" role="alert"><?php echo Yii::t('app', 'No more answers.');?></div>
					<?php endif ?>
				</section>
				<section id="section-focus">
       		<div class="alert alert-warning" role="alert"><?php echo Yii::t('app', 'No more focus questions.');?></div>
				</section>
			</div>
		</div>
	</div>


<script type="text/javascript" src="/js/cbpFWTabs.js"></script>
<script type="text/javascript">
	new CBPFWTabs( document.getElementById( 'tabs' ) );
</script>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\markdown\MarkdownEditor;
use app\assets\VideoPlay;
use app\assets\CommentEmoji;
use app\models\CourseComment;
use app\models\Answer;
use app\models\Question;
use app\models\User;
use kartik\markdown\Markdown;
use app\models\Common;
use app\models\Course;
use app\models\Category;


VideoPlay::register($this);
CommentEmoji::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$categoryModel = Category::findOneById($course->category);

$this->title = Yii::t('app', 'Play');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course'), 'url' => ['/course/list']];
$this->params['breadcrumbs'][] = ['label' => $categoryModel->name, 'url' => ["/course/list?c=".$categoryModel->alias]];
$this->params['breadcrumbs'][] = ['label' => $course->name, 'url' => ["/course/learn?cid=".Course::findOneById($course->root)->id]];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="container">
	<div class="row col-lg-10">
		<video id="video-player" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="1120" height="550" poster="" data-setup="{}" autoplay='true'>
			<source src="<?php echo $url?>" type='video/mp4'>
			
			<!-- 如果浏览器不兼容HTML5则使用flash播放 -->
		    <object id="video-player-flash" class="vjs-flash-fallback" width="1120" height="550" type="application/x-shockwave-flash" data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
		        <param name="movie"
		            value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
		        <param name="allowfullscreen" value="true" />
		        <param name="flashvars" value='config={"playlist":["", {"url": "<?php echo $url?>","autoPlay":false,"autoBuffering":true}]}' />
		        <!-- 视频图片. -->
		        <img src="" width="1120" height="550" alt="Poster Image" title="No video playback capabilities." />
		    </object>

		</video>
	</div>
	
	<div class="row col-lg-2 col-lg-offset-5 col-md-offset-5 col-sm-offset-5 col-xs-offset-5" style="margin-top:20px">
		<div class="btn-group dropup" id="play-rate-btn" >
		  	<button type="button" class="btn btn-info" id='show-play-rate'>1.0X</button>
		  	<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    	<span class="caret"></span>
		    	<span class="sr-only" >Toggle Dropdown</span>
		  	</button>
		  	<ul class="dropdown-menu" style="background-color: #999">
		    	<li><a href="javascript:void(0)">0.5X</a></li>
		    	<li><a href="javascript:void(0)">0.75X</a></li>
		    	<li><a href="javascript:void(0)">1.0X</a></li>
		    	<li role="separator" class="divider"></li>
		    	<li><a href="javascript:void(0)">1.25X</a></li>
		    	<li><a href="javascript:void(0)">1.5X</a></li>
		    	<li><a href="javascript:void(0)">1.75X</a></li>
		    	<li><a href="javascript:void(0)">2.0X</a></li>
		 	 </ul>
		</div>
	</div>

	<div class="row col-lg-12 video-menu">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#comment" data-toggle="tab">评论</a></li>
			<li><a href="#qa" data-toggle="tab">问答</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="comment">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-input">
          <textarea class="form-control" placeholder="扯淡、吐槽、表扬、鼓励……想说啥就说啥！" id="comment-input" rows="3"></textarea>
          <button class="btn btn-info emotion" type="button"><span class="icon-smile icon-large">&nbsp;添加表情</span></button>
        	<button class="btn btn-success comment-send" type="button" id="addCommentSubmit"><span class="icon-mail-forward icon-large">&nbsp;发表评论</span></button>
        </div>
        

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comment-detail">
					<?php if (CourseComment::commentList($course->id)): ?>					
						<?php $i = 1; foreach (CourseComment::commentList($course->id) as $comment): ?>
							<div class="media col-lg-12 evaluation-con">
							  <div class="media-left media-middle">
							    <a href="#">
							      <img class="media-object img-circle" src="<?php echo User::findModel($comment->user_id)->head_picture?>" alt="" width="60px">
							    </a>
							  </div>
							  <div class="media-body">
							  	<span class="evaluation-name"><?php echo User::findModel($comment->user_id)->username?></span>
							    <h5 class="media-heading evaluation-content" id="comment-content-<?php echo $i?>"><?php echo $comment->content?></h5>
							    <?php if ($comment->course_id == $comment->root_id): ?>
							    	<span class="evaluation-time">时间：<?php echo Common::getAwayTime($comment->comment_time)?></span>
									<?php else: ?>
							    	<span class="evaluation-time">时间：<?php echo Common::getAwayTime($comment->comment_time)?>&nbsp;<a href="/resource/play?id=<?php echo Resource::getVideo($comment->course_id)->url?>">源自:<?php Course::findModel($comment->course_id)->name?></a></span>
							    <?php endif ?>
							    <span class="fa fa-thumbs-o-down comment-down" onclick="commentDown(<?php echo $comment->id?>)"><?php echo $comment->down_count?></span>
							    <span class="fa fa-thumbs-o-up comment-up" onclick="commentUp(<?php echo $comment->id?>)"><?php echo $comment->up_count?></span>
							  </div>
							</div>
						<?php $i++;endforeach ?>
					<?php else: ?>
					  <div class="alert alert-warning" role="alert" style="margin-top: 15px"><?php echo Yii::t('app', 'No more comments.');?></div>
					<?php endif ?>

				</div>





			</div>
			<div class="tab-pane" id="qa">
				<div class="qa-input" style="margin-top:20px">
					<?php
						echo MarkdownEditor::widget([
						    'name' => 'markdown', 
						    'options' => ['placeholder' => '求大神！'],
						    'height' => 150,
						]);
					?>
				</div>

				<div class="qa-detail">
					<?php foreach (Question::getQuestionList($course->id) as $question): ?>
						<div class="media col-lg-12">
						  <div class="media-left media-middle col-lg-2">
						    <a href="#">
						      <img class="media-object img-circle" style="margin: 6% 0 0 0 " src="<?php echo User::findModel($question->user_id)->head_picture?>" alt="" width="60px">
						    </a>
						    <span class="qa-name" style="text-align: center"><?php echo User::findModel($question->user_id)->username?></span>
						  </div>
						  <div class="media-body">
						  	<span class="fa fa-question-circle fa-lg col-lg-1 qa-question-fa"></span>
						    <span class="media-heading qa-content" ><?php echo Markdown::convert($question->content)?></span>
						    <div class="qa-new">
						    	<span class="fa fa-comment fa-lg col-lg-1"></span>
						    	<?php if (Answer::replyLatest($question->id)): ?>
						    		<span>[最新回答]</span>
						    		<span><a href=""><?php echo User::findModel(Answer::replyLatest($question->id)->answer_user_id)->username?> :</a></span>
						    		<span><?php echo Answer::replyLatest($question->id)->content?></span>
						    	<?php else: ?>
						    		<span>[还没有人回答]</span>
						    	<?php endif ?>
						    	
						    </div>
						    <span class="evaluation-time col-lg-4">时间：<?php echo Common::getAwayTime($question->create_time)?></span>
						    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-comments comment-down"><?php echo count(Answer::replyList($question->id))?></span></a>
						    <a href="/course/qadetail?qid=<?php echo $question->id?>"><span class="fa fa-eye comment-up"><?php echo $question->views?></span></a>
						  </div>
						</div>
					<?php endforeach ?>
				</div>


			</div>
	</div>

</div>


<input type="hidden" id="course_id" value="<?php echo $course->id?>"/>
<input type="hidden" id="learn_point" value="<?php echo $learnPoint?>"/>


<script type="text/javascript" src="/js/jquery.min.js"></script>
<script>
 	$(document).ready(function(){
 		var startTime = 0;
 		var endTime = 0;
 		var duration = 0;
 		videojs.options.flash.swf = "/video-js/video-js.swf";
 		var video = document.getElementById('video-player');

		video.addEventListener("loadedmetadata", function(){
			startTime = new Date();
	    video.volume = 0.5;
	    video.currentTime = $('#learn_point').val();
	    video.playbackRate = 1;
	    setInterval(function(){
	    	$.ajax({
          type: 'POST',
          url: '/user-play/play-point',
          data: {
          	courseId: $('#course_id').val(),
          	point: video.currentTime,
          }
      	});
	    }, 10000);
		});

		video.addEventListener("ended", function(){
			endTime = new Date();
			duration = endTime.getTime() - startTime.getTime();
      duration /= 1000;//取秒
			$.ajax({
          type: 'POST',
          url: '/user-play/play-end',
          data: {
          	courseId: $('#course_id').val(),
          }
      });
		});
		
		$('#play-rate-btn ul li').each(function(i){
			$(this).click(function(){
				var rate = $(this).text();
				$('#show-play-rate').text(rate);
				// $(this).children().css('color', 'red');
				video.playbackRate = rate.substring(0, rate.indexOf('X'));
			});
		});

		$(window).bind('beforeunload', function(e) {
        endTime = new Date();//用户退出时间
        duration = endTime.getTime() - startTime.getTime();
        duration /= 1000;//取秒
        $.ajax({
            type: 'POST',
            async: false,//关闭异步
            url: '/user-course/add-play-time',
            data: {
            	courseId: $('#course_id').val(),
            	duration:duration,
            },
        });
        // return '您输入的内容尚未保存，确定离开此页面吗？';
    });

 	});

	$(function(){
		$('.emotion').qqFace({
		  id : 'facebox', 
		  assign:'comment-input', 
		  path:'/img/face/'  
    });
  });




</script>


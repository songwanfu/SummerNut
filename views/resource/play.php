<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\markdown\MarkdownEditor;
use app\assets\VideoPlay;
use app\assets\CommentEmoji;

VideoPlay::register($this);
CommentEmoji::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Play');
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="container">
	<div class="row col-lg-8 col-lg-offset-2">
		<video id="video-player" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="640" height="264" poster="" data-setup="{}" autoplay='true'>
			<source src="<?php echo $url?>" type='video/mp4'>
			
			<!-- 如果浏览器不兼容HTML5则使用flash播放 -->
		    <object id="video-player-flash" class="vjs-flash-fallback" width="640" height="264" type="application/x-shockwave-flash" data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
		        <param name="movie"
		            value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
		        <param name="allowfullscreen" value="true" />
		        <param name="flashvars" value='config={"playlist":["", {"url": "<?php echo $url?>","autoPlay":false,"autoBuffering":true}]}' />
		        <!-- 视频图片. -->
		        <img src="" width="640" height="264" alt="Poster Image" title="No video playback capabilities." />
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

					<div class="media col-lg-12 evaluation-con">
					  <div class="media-left media-middle">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/545868f30001886f02200220-40-40.jpg" alt="..." width="60px">
					    </a>
					  </div>
					  <div class="media-body">
					  	<span class="evaluation-name">黎丶小小小陌</span>
					    <h5 class="media-heading evaluation-content">挺棒的 支持。</h5>
					    <span class="evaluation-time">时间：1天前</span>
					    <span class="icon-thumbs-down comment-down">1</span>
					    <span class="icon-thumbs-up comment-up">10</span>
					  </div>
					</div>
					<div class="media col-lg-12 evaluation-con">
					  <div class="media-left media-middle">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/56dc4a6c0001dbb202000200-40-40.jpg" alt="..." width="60px">
					    </a>
					  </div>
					  <div class="media-body">
					  	<span class="evaluation-name">programme</span>
					    <h5 class="media-heading evaluation-content">在项目中很实用</h5>
					    <span class="evaluation-time">时间：1天前</span>
					    <span class="icon-thumbs-down comment-down">1</span>
					    <span class="icon-thumbs-up comment-up">10</span>
					  </div>
					</div>

				</div>





			</div>
			<div class="tab-pane" id="qa">
				<div class="qa-input">
					<?php
						echo MarkdownEditor::widget([
						    'name' => 'markdown', 
						    'options' => ['placeholder' => '求大神！'],
						    'height' => 150,
						]);
					?>
				</div>

				<div class="qa-detail">
					<div class="media col-lg-12">
					  <div class="media-left media-middle col-lg-2">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/545868f30001886f02200220-40-40.jpg" alt="..." width="60px">
					    </a>
					    <span class="qa-name">黎丶小小小陌</span>
					  </div>
					  <div class="media-body">
					  	<span class="icon-question-sign icon-large"></span>
					    <span class="media-heading qa-content">$('input').eq(1)与$("input:eq(2)") 什么区别？</span>
					    <div class="qa-new">
					    	<span class="icon-comment icon-large"></span>
					    	<span>[最新回答]</span>
					    	<span><a href="">lejsure: </a></span>
					    	<span>找到答案了，不妥之处欢迎指正$( "selector" ).eq( index );//等价于$( "selector:eq(index)" );</span>
					    </div>
					    <span class="evaluation-time">时间：1天前</span>
					    <span class="icon-comments comment-down">1</span>
					    <span class="icon-eye-open comment-up">10</span>
					  </div>
					</div>
					<div class="media col-lg-12">
					  <div class="media-left media-middle col-lg-2">
					    <a href="#">
					      <img class="media-object img-circle" src="http://img.mukewang.com/user/534d3a85000149d401000100-40-40.jpg" alt="..." width="60px">
					    </a>
					    <span class="qa-name"> Mr_Hs1ung</span>
					  </div>
					  <div class="media-body">
					  	<span class="icon-question-sign icon-large"></span>
					    <span class="media-heading qa-content">绝对定位是拉伸没搞明白</span>
					    <div class="qa-new">
					    	<span class="icon-comment icon-large"></span>
					    	<span><a href="">[我来回答]</a></span>
					    </div>
					    <span class="evaluation-time">时间：7小时前 </span>
					    <span class="icon-comments comment-down">1</span>
					    <span class="icon-eye-open comment-up">10</span>
					  </div>
					</div>
				</div>


			</div>
	</div>

</div>




<script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.2.0/jquery.js"></script>
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
		    video.currentTime = 0;
		    video.playbackRate = 1;
		    setInterval(function(){
		    	console.log(video.currentTime);
		    }, 10000);
		});

		video.addEventListener("ended", function(){
			endTime = new Date();
			duration = endTime.getTime() - startTime.getTime();
            duration /= 1000;//取秒
			$.ajax({
                type: 'GET',
                url: '/video/play-end',
                data: {duration:duration}
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
                type: 'GET',
                async: false,//关闭异步
                url: '/video/play-time',
                data: {duration:duration}
            });
            return '您输入的内容尚未保存，确定离开此页面吗？';
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


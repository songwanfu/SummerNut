<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\VideoPlay;

VideoPlay::register($this);

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

</script>


<?php
use kartik\tabs\TabsX;
?>

<div class="background">
	<img src="http://static.mukewang.com/static/img/u/temp1.jpg">
</div>

<div class="zone container">
	<div class="row">
		<div class="col-lg-12 user-info">

			<div class="col-lg-2 user-head-pic">
				<img src="http://www.songwanfu.com/img/me.jpg" class="img-circle">
			</div>
			<div class="col-lg-3 zone-username">
				<h2>songwanfu</h2>
				<h4 class="signature">hello,world</h4>
			</div>

			<div class="col-lg-3 col-lg-offset-4 zone-nut">
				<ul class="list-inline">
				  <li class="col-lg-6">
				  	<h4>23小时26分</h4>
				  	<h5>学习时长</h5>
				  </li>
				  <li class="col-lg-6">
				  	<h4>999</h4>
				  	<h5>果果</h5>
				  </li>
				</ul>
			</div>
		</div>

		<div class="col-lg-2 zone-user-sex">
			<span class="fa fa-mars" style="text-align: center"></span>
		</div>

		<div class="col-lg-12 zone-user-menu">
			<?php
			$html = "";
			$items = [
			    [
			        'label'=>'<i class="glyphicon glyphicon-list"></i> Course',
			        'content'=>"<img src='ss'>",
			        'active'=>true
			    ],
			    [
			        'label'=>'<i class="glyphicon glyphicon-question-sign"></i> QA',
			        'content'=>'2',
			        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/test'])]
			    ],
			    [
			        'label'=>'<i class="glyphicon glyphicon-pencil"></i>Article',
			        'content'=>'2',
			        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/test'])]
			    ],
			    [
			        'label'=>'<i class="glyphicon glyphicon-cog"></i> 设置',
			        'content'=>'2',
			        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/user/show-profile'])]
			    ],
			];

				echo TabsX::widget([
				    'items'=>$items,
				    'position'=>TabsX::POS_LEFT,
				    'encodeLabels'=>false
				]);
			?>
		</div>
	</div>
</div>
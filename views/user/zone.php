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
				<img src="<?php echo $model->head_picture?>" class="img-circle" id="user-head-pic" width="140px">
			</div>
			<div class="col-lg-3 zone-username">
				<h2><?php echo $model->username;?></h2>
				<h4 class="signature"><?php echo $model->signature;?></h4>
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
			<?php if ($model->sex == $model::SEX_FEMALE) : ?>
				<span class="fa fa-venus"></span>
			<?php endif; ?>
			<?php if ($model->sex == $model::SEX_MALE) : ?>
				<span class="fa fa-mars"></span>
			<?php endif; ?>
			<?php if ($model->sex == $model::SEX_SECRET) : ?>
				<span class="fa fa-genderless"></span>
			<?php endif; ?>
			
		</div>

		<div class="col-lg-10 zone-user-menu">
			<?php
			$items = [
			    [
			        'label'=>'<i class="glyphicon glyphicon-list"></i> Course',
			        'content'=> $htmlCourse,
			        'active'=>true
			    ],
			    [
			        'label'=>'<i class="glyphicon glyphicon-question-sign"></i> QA',
			        'content'=>'2',
			        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/user/show-qa'])]
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

<script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
<script type="text/javascript">
		function changeHeadPic()
		{
			var list = headPicList();
			var url = list[Math.ceil(Math.random()*50)];
			$('#head_pic').attr('src', url);
			// $('#user-head-pic').attr('src', url);return;
			$.ajax({
				type : 'post',
				url : '/user/refresh-head-pic',
				dataType : 'json',
				async: false,
				data : {
					headPic : url,
				},
				success : function (json) {
					if (json == 'true') {
						$('#user-head-pic').attr('src', url);
					}
				}
			});
		}
</script>

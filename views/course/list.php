<?php
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Course');
?>

<div class="row">
	<h4>全部课程</h4>
</div>
<hr>
<div class="list-query">
	<div class="row">
		<p class="col-lg-1 col-md-1 col-sm-2 list-query-type">方向:</p>
		<ul class="col-lg-11 col-md-11 col-sm-10 nav nav-pills">
		  <li role="menu" ><a href="#">全部</a></li>
		  <li role="menu" ><a href="#" class="gray">前端开发</a></li>
		  <li role="menu" ><a href="#">后端开发</a></li>
		  <li role="menu" ><a href="#">移动开发</a></li>
		</ul>
		<hr>
	</div>

	<div class="row">
		<p class="col-lg-1 col-md-1 col-sm-2 list-query-type">分类:</p>
		<ul class="col-lg-11 col-md-11 col-sm-10 nav nav-pills">
		  <li role="menu" ><a href="#">全部</a></li>
		  <li role="menu" ><a href="#" class="gray">HTML/CSS</a></li>
		  <li role="menu" ><a href="#">JAVA</a></li>
		  <li role="menu" ><a href="#">PHP</a></li>
		  <li role="menu" ><a href="#">HTML/CSS</a></li>
		  <li role="menu" ><a href="#">JAVA</a></li>
		  <li role="menu" ><a href="#">PHP</a></li>
		</ul>
		<hr>
	</div>

	<div class="row">
		<p class="col-lg-1 col-md-1 col-sm-2 list-query-type">难度:</p>
		<ul class="col-lg-11 col-md-11 col-sm-10 nav nav-pills">
		  <li role="menu" ><a href="#" class="gray">全部</a></li>
		  <li role="menu" ><a href="#">初级</a></li>
		  <li role="menu" ><a href="#">中级</a></li>
		  <li role="menu" ><a href="#">高级</a></li>
		</ul>
		<hr>
	</div>
</div>


	<div class="row">
			<div class="col-lg-12">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#new" data-toggle="tab">最新</a></li>
					<li><a href="#hot" data-toggle="tab">最热</a></li>
				</ul>
				<div class="tab-content">

					
					<div class="tab-pane active" id="new">
						<div class="row list-preivew">
							<div class="col-lg-3 col-md-3 ">
								<a href=""><img src="http://img.mukewang.com/567252db0001b9ea06000338-240-135.jpg" class="img-rounded blur"></a>
								<h5 style="text-align: left">CSS深入理解之relative</h5>
								<h6 class="course-tips">relative实际使用经验分享，必学！</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">9773人学习</span>
							</div>
							<div class="col-lg-3 col-md-3">
								<img src="http://img.mukewang.com/56720f3800016b6206000338-240-135.jpg" class="img-rounded">
								<h5 style="text-align: left">去哪儿前端沙龙分享第三期</h5>
								<h6 class="course-tips">去哪儿网前端交互沙龙第三期！</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">14397人学习</span>
							</div>
							<div class="col-lg-3 col-md-3">
								<img src="http://img.mukewang.com/56653a860001cbaa06000338-240-135.jpg" class="img-rounded">
								<h5 style="text-align: left">H5+JS+CSS3 实现圣诞情缘</h5>
								<h6 class="course-tips">relative实际使用经验分享，必学！</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">37463人学习</span>
							</div>
							<div class="col-lg-3 col-md-3">
								<img src="http://img.mukewang.com/55dd982f0001ecb906000338-240-135.jpg" class="img-rounded">
								<h5 style="text-align: left">DOM探索之基础详解篇</h5>
								<h6 class="course-tips">前端大牛都是从精通DOM开始的，你准备好了吗！</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">36576人学习</span>
							</div>
						</div>
					</div>


					<div class="tab-pane" id="hot">
						<div class="row">
							<div class="col-lg-3 col-md-3 list-preivew">
								<img src="http://img.mukewang.com/529dc3380001379906000338-240-135.jpg" class="img-rounded">
								<h5 style="text-align: left">HTML+CSS基础课程</h5>
								<h6 class="course-tips">8小时带领大家步步深入学习标签的基础知识，掌握各种样式的基本用法。</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">274368人学习</span>
							</div>
							<div class="col-lg-3 col-md-3 list-preivew">
								<img src="http://img.mukewang.com/53eafb44000146c706000338-240-135.jpg" class="img-rounded">
								<h5 style="text-align: left">网页布局基础</h5>
								<h6 class="course-tips">让你精通CSS中三大定位机制—标准文档流、浮动及绝对定位，彻底掌握布局所有技能！</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">84842人学习</span>
							</div>
							<div class="col-lg-3 col-md-3 list-preivew">
								<img src="http://img.mukewang.com/56653a860001cbaa06000338-240-135.jpg" class="img-rounded">
								<h5 style="text-align: left">H5+JS+CSS3 实现圣诞情缘</h5>
								<h6 class="course-tips">relative实际使用经验分享，必学！</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">37463人学习</span>
							</div>
							<div class="col-lg-3 col-md-3 list-preivew">
								<img src="http://img.mukewang.com/53eafb7a0001828906000338-240-135.jpg" class="img-rounded">
								<h5 style="text-align: left">如何用CSS进行网页布局</h5>
								<h6 class="course-tips">技术大牛用最最简洁的案例教你一列布局、二列布局、三列布局以及混合布局知识。</h6>
								<span class="course-leaner">更新完毕</span>
								<span class="course-status">61308人学习</span>
							</div>
						</div>
					</div>
						

				</div>
			</div>
	</div>

<?php 
// echo LinkPager::widget([
//     'pagination' => 6,
// ]);
?>

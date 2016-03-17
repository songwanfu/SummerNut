<?php
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Learn');

// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = 'HTML/CSS';
// $this->params['breadcrumbs'][] = 'CSS深入理解之relative';
?>

<div class="wrap">
	<div class="row course-view-infos">
		<?= $this->render('course-top', ['course' => $course, 'categoryModel' => $categoryModel])?>
	</div>

	<div class="row learn-body">
		<div class="col-lg-9 course-learn-body">
			<div class="learn-progress progress">
			  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
			    已学60%用时0小时49分
			  </div>
			</div>
			<div class="col-lg-12 course-menu">
				<ul class="list-inline">
				  <li class="col-lg-4 menu-active"><h4>章节</h4></li>
				  <li class="col-lg-4"><h4>评论</h4></li>
				  <li class="col-lg-4"><h4>问答</h4></li>
				</ul>
			</div>

			<div class="col-lg-12 course-learn-chapter">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          <span class="fa fa-list"></span>第1章 relative和absolute相煎何太急
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				      <div class="panel-body">
								<span class="fa fa-play-circle-o"></span><span class="chapter-h2">1-1 relative和absolute的相煎关系 (07:28)</span>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingTwo">
				      <h4 class="panel-title">
				        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				          <span class="fa fa-list"></span>第2章 relative与定位
				        </a>
				      </h4>
				    </div>
				    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				      <div class="panel-body">
				      	2-1 relative和定位 (08:19)
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingThree">
				      <h4 class="panel-title">
				        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				          <span class="fa fa-list"></span>第3章 relative与z-index层级的关系
				        </a>
				      </h4>
				    </div>
				    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				      <div class="panel-body">
				      	3-1 relative和层级 (04:24)
				      </div>
				    </div>
				  </div>
				</div>



			</div>


		</div>

		<div class="col-lg-3  course-view-right">
			<?= $this->render('course-right', ['isLearn' => true, 'course' => $course])?>

		</div>

	</div>


</div>
<?php
use yii\widgets\LinkPager;
use app\models\Course;
use app\models\Resource;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Learn');

$chapterList = Course::getChapterList($course->id);

$resModel = new Resource();
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
				  <li class="col-lg-4 menu-active"><a href="/course/learn?cid=<?php echo $course->id;?>"><h4>章节</h4></a></li>
				  <li class="col-lg-4"><a href="/course/comment?cid=<?php echo $course->id;?>"><h4>评论</h4></a></li>
				  <li class="col-lg-4"><a href="/course/qa?cid=<?php echo $course->id;?>"><h4>问答</h4></a></li>
				</ul>
			</div>

			<div class="col-lg-12 course-learn-chapter">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<?php $i = 1; foreach ($chapterList as $chapter): ?>
						<div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="heading<?php echo $i;?>">
					      <h4 class="panel-title">
					        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapseOne">
					          <span class="fa fa-list"></span><?php echo $chapter['chapterName'];?>
					        </a>
					      </h4>
					    </div>
					    <div id="collapse<?php echo $i;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					      	<?php foreach (Course::getChapterFiles($chapter['id'], $chapter['lft'], $chapter['rgt']) as $model): ?>
										<div class="learn-course-name"><a href="/resource/play?id=<?php $res = $resModel->getVideo($model->id);echo $res['id'];?>"><span class="fa fa-play-circle-o"></span><span class="chapter-h2"><?php echo $model->name;?></span></a></div>
									<?php endforeach;?>
					      </div>

					    </div>
					  </div>
					<?php $i++;endforeach; ?>
			
				</div>



			</div>


		</div>

		<div class="col-lg-3  course-view-right">
			<?= $this->render('course-right', ['isLearn' => true, 'course' => $course])?>

		</div>

	</div>


</div>
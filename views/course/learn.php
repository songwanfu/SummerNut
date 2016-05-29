<?php
use yii\widgets\LinkPager;
use app\models\Course;
use app\models\Resource;
use app\models\UserCourse;

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
		<div class="col-lg-9 col-md-9 col-sm-9 course-learn-body">
			<div class="learn-progress progress">
				<?php if ($learnPersent == 0): ?>
					<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
				    <span >已学<?php echo $learnPersent . '%'?> 用时 <?php echo $learnTimeToal?></span>
				  </div>
				<?php else: ?>
				  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $learnPersent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $learnPersent?>%;">
				    <span >已学<?php echo $learnPersent . '%'?> 用时 <?php echo $learnTimeToal?></span>
				  </div>
			  <?php endif ?>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 course-menu">
				<ul class="list-inline">
				<li class="col-lg-4 col-md-4 col-sm-4 menu-active"><a href="/course/learn?cid=<?php echo $course->id;?>"><h4><?php echo Yii::t('app', 'Chapter')?></h4></a></li>
				<li class="col-lg-4 col-md-4 col-sm-4 "><a href="/course/comment?cid=<?php echo $course->id;?>"><h4><?php echo Yii::t('app', 'Comments')?></h4></a></li>
				<li class="col-lg-4 col-md-4 col-sm-4"><a href="/course/qa?cid=<?php echo $course->id;?>"><h4><?php echo Yii::t('app', 'QA')?></h4></a></li>
				</ul>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 course-learn-chapter">
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

		<div class="col-lg-3  col-md-3 col-sm-3 course-view-right">
			<?= $this->render('course-right', ['isLearn' => true, 'course' => $course])?>

		</div>

	</div>


</div>

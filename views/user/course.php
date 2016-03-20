<?php
use kartik\tabs\TabsX;
use app\models\UserCourse;
use app\models\Course;
use app\models\UserPlay;
use app\models\Common;
?>

<link rel="stylesheet" type="text/css" href="/css/user-course.css">

    <div class="row col-lg-10 col-md-10 col-sm-10 user-course">
      <?php if (!empty(UserCourse::findModelsByUserId($user->id))): ?>
        <ul class="cbp_tmtimeline">
          <?php foreach (UserCourse::findModelsByUserId($user->id) as $userCourse): ?>    
            <li>
              <time class="cbp_tmtime" datetime="">
                <span><?php echo date('Y-m-d', strtotime($userCourse->create_time))?></span> <span><?php echo date('H:i', strtotime($userCourse->create_time))?></span></time>
              <div class="cbp_tmicon cbp_tmicon-learn">
                <?php if ($userCourse->type == UserCourse::TYPE_FOCUS): ?>
                  <abbr title="focus" class="initialism"><span class="fa fa-heart"></span></abbr>
                <?php else :?>
                  <abbr title="learn" class="initialism"><span class="fa fa-tasks"></span></abbr>
                <?php endif ?>
              	
              </div>
              <div class="cbp_tmlabel">
                <h2><?php echo Course::findOneById($userCourse->course_id)->name?></h2>
                <a href="/course/view?cid=<?php echo Course::findOneById($userCourse->course_id)->id?>"><img src="<?php echo Course::findOneById($userCourse->course_id)->icon?>" alt="" class="img-rounded"></a>
                <?php if ($userCourse->type == UserCourse::TYPE_LEARN): ?>
                  <span >已学<?php echo UserPlay::getLearnPercent(Yii::$app->user->id, $userCourse->course_id) * 100 . '%'?> 用时 <?php echo Common::transTime(UserCourse::findOneLearnModel(Yii::$app->user->id, $userCourse->course_id)->learn_time_total)?></span>
                <?php endif ?>

              </div>
            </li>
          <?php endforeach ?>
        </ul>
      <?php else: ?>
       <div class="alert alert-warning" role="alert" style="margin-top: 15px"><?php echo Yii::t('app', 'No more focus or learn courses.');?></div>
      <?php endif ?>
    </div>




<script type="text/javascript" src="/js/jquery.min.js"></script>

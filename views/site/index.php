<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Summer Nut');
?>




<div class="site-index">

    <div class="container-fluid">
        <div class="row col-lg-12 col-md-12 col-sm-12">
            <div id="carousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <?php $i = 1;?>
                <?php foreach ($bannerList as $banner) : ?>
                  <?php if ($i == 1) : ?>
                    <div class="item active">
                  <?php else : ?>
                    <div class="item">
                  <?php endif;?>
                    <a href="<?php echo $banner->jump_target?>"><img src="<?php echo $banner->img?>" alt=""></a>
                    <div class="carousel-caption">
                      <?php echo $banner->title;$i++;?>
                    </div>
                  </div>
                <?php endforeach;?>

              <!-- Controls -->
              <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </div>
    </div>
    

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <h2>聚焦</h2>

                <p>以知识点为基本单位，每个微课讲述一个主题。</p>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <h2>互动</h2>

                <p>对微课进行讨论和问答。</p>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <h2>高效</h2>

                <p>教师的一次讲述，将被多次播放和学习。</p>
            </div>
        </div>
        

    </div>


    <div class="jumbotron jumbotron-index">
        <h1>知识触手可及!</h1>

        <p class="lead">夏果微课堂助您成长。</p>

        <p><a class="btn btn-lg btn-success" href="/course/list"><?php echo Yii::t('app', 'Learn Now');?></a></p>
    </div>
</div>


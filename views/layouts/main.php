<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\user;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/img/icon.jpg" rel="shortcut icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'Summer Nut'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => Yii::t('app', 'Course'), 'url' => ['/course/list']],
                ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
                [
                    'label' => Yii::t('app', 'Widgets'),
                    'items' => [
                        [
                            'label' => Yii::$app->language == 'en-US' ?  '中文' : 'English',
                            'url' => ["/site/language"],
                            'linkOptions' => ['data-method' => 'post'],
                        ], 
                    ]
                ],

                Yii::$app->user->isGuest ? (
                    ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']]
                ) : 
                    (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
  
    }else if (User::isStudent(Yii::$app->user->id)) {

       echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => Yii::t('app', 'Course'), 'url' => ['/course/list']],
                ['label' => Yii::t('app', 'Zone'), 'url' => ['/user/zone']],
                ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
                [
                    'label' => Yii::t('app', 'Widgets'),
                    'items' => [
                        [
                            'label' => Yii::$app->language == 'en-US' ?  '中文' : 'English',
                            'url' => ["/site/language"],
                            'linkOptions' => ['data-method' => 'post'],
                        ], 
                    ]
                ],

                Yii::$app->user->isGuest ? (
                    ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']]
                ) : 
                    (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
    } else if (User::isTeacher(Yii::$app->user->id)) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => Yii::t('app', 'Course'), 'url' => ['/course/list']],
                ['label' => Yii::t('app', 'Course Manage'), 'url' => ['/course/manage']],
                ['label' => Yii::t('app', 'Tasks'), 'url' => ['/task/index']],
                ['label' => Yii::t('app', 'Zone'), 'url' => ['/user/zone']],
                ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
                [
                    'label' => Yii::t('app', 'Widgets'),
                    'items' => [
                        [
                            'label' => Yii::$app->language == 'en-US' ?  '中文' : 'English',
                            'url' => ["/site/language"],
                            'linkOptions' => ['data-method' => 'post'],
                        ], 
                    ]
                ],

                Yii::$app->user->isGuest ? (
                    ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']]
                ) : 
                    (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
    } else if (User::isAdmin(Yii::$app->user->id)) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => Yii::t('app', 'Course Manage'), 'url' => ['/course/manage']],
                ['label' => Yii::t('app', 'Tasks'), 'url' => ['/task/index']],
                ['label' => Yii::t('app', 'Resource'), 'url' => ['/resource/index']],
                ['label' => Yii::t('app', 'Category'), 'url' => ['/category/index']],
                ['label' => Yii::t('app', 'Banner'), 'url' => ['/banner/index']],
                ['label' => Yii::t('app', 'User'), 'url' => ['/user/index']],
                ['label' => Yii::t('app', 'Question'), 'url' => ['/question/index']],
                ['label' => Yii::t('app', 'Answer'), 'url' => ['/answer/index']],
                ['label' => Yii::t('app', 'Nut'), 'url' => ['/nut/index']],
                ['label' => Yii::t('app', 'Zone'), 'url' => ['/user/zone']],
                [
                    'label' => Yii::t('app', 'Widgets'),
                    'items' => [
                        [
                            'label' => Yii::$app->language == 'en-US' ?  '中文' : 'English',
                            'url' => ["/site/language"],
                            'linkOptions' => ['data-method' => 'post'],
                        ], 
                    ]
                ],

                Yii::$app->user->isGuest ? (
                    ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']]
                ) : 
                    (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
    }

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?php echo Yii::t('app', 'Summer Nut');?> <?= date('Y') ?></p>

        <p class="pull-right"><a href="mailto:imsongwanfu@163.com"><?= Yii::t('app', 'Email') ?></a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

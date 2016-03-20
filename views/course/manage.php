<?php
use kartik\tree\TreeView;
use app\models\Course;
use yii\helpers\html;
 
 $this->title = Yii::t('app', 'Course Manage');

echo TreeView::widget([
    // single query fetch to render the tree
    // use the Product model you have in the previous step
    'query' => Course::find()->addOrderBy('root, lft'), 
    'headingOptions' => ['label' => Yii::t('app', 'Contents')],
    'fontAwesome' => false,     // optional
    'isAdmin' => true,         // optional (toggle to enable admin mode)
    'displayValue' => 1,        // initial display value
    'softDelete' => true,       // defaults to true
    'cacheSettings' => [        
        'enableCache' => true   // defaults to true
    ]
]);
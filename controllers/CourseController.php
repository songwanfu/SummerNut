<?php
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CourseController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'view', 'update', 'delete', 'test'], 
                            'roles' => ['@'],
                        ],
                    ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
    	$model = new Course();
    	echo $model->maxDepth();
    }



}

<?php
namespace app\controllers;
use app\models\Course;
use Yii;
class CourseController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
    	var_dump(Yii::$app->user->id);
    }

}

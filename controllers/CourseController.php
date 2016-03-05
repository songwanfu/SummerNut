<?php
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Course;
use app\models\Resource;

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
                            'actions' => ['index', 'create', 'view', 'update', 'delete', 'test', 'upload', 'delete-icon'], 
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

    public function actionUpload()
    {
        $model = new Course();
        $data = Yii::$app->request->post();
        $id = $data['Course']['id'];
        $model = $model::findModel($id);

        $resourceModel = new Resource();
        $model = $resourceModel->uploadImg($model, 'icon');

        if ($model) {
            if ($model->save()) {
                 $res = [
                    'initialPreview' => '<p>' . Yii::t('app', 'Upload success!') . '</p>',
                ];
                echo json_encode($res);
            }
           
        }
       
    }

    public function actionDeleteIcon($id)
    {
        $model = new Course();
        $model = $model::findModel($id);
        $model->icon = '';
        if ($model->save()) {
            echo json_encode(true);
            return; 
        }
        echo json_encode(false);
    }



}

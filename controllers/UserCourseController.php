<?php

namespace app\controllers;

use Yii;
use app\models\UserCourse;
use app\models\Course;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\models\UserPlay;
use yii\filters\AccessControl;

/**
 * UserCourseController implements the CRUD actions for UserCourse model.
 */
class UserCourseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'delete', 'add-focus', 'drop-focus', 'add-play-time'], 
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

    /**
     * Lists all UserCourse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UserCourse::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserCourse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserCourse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserCourse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddFocus()
    {
    	$courseId = Yii::$app->request->post('courseId');
    	$userId = Yii::$app->user->id;
    	if (UserCourse::isFocus($userId, $courseId)) {
    		echo true;
    		return;
    	} else {
    		if (UserCourse::addData($userId, $courseId, UserCourse::TYPE_FOCUS)) {
    			echo true;
    			return;
    		}
    	}
    	echo false;
    }

    public function actionDropFocus()
    {
    	$courseId = Yii::$app->request->post('courseId');
    	$userId = Yii::$app->user->id;
    	if (UserCourse::isFocus($userId, $courseId)) {
    		if (UserCourse::deleteFocus($userId, $courseId, UserCourse::TYPE_FOCUS)) {
    			echo true;
    			return;
    		}
    	} else {
    		echo true;
    		return;
    	}
    	echo false;
    }


    public function actionAddPlayTime()
    {
        $chapterId = Yii::$app->request->post('courseId');
        $duration = Yii::$app->request->post('duration');
        $userId = Yii::$app->user->id;

        $courseId = Course::findOneById(Course::findOneById($chapterId)->root)->id;

        //写入play表
        $userPlayModel = new UserPlay();
        $userPlayModel = $userPlayModel->findOneLearnModel($userId,$chapterId);
        $userPlayModel->learn_time_total += ceil($duration);
        $userPlayModel->save();

        //写入usercourse表
        $model = UserCourse::findOneLearnModel($userId, $courseId);
        $model->learn_time_total += ceil($duration);

        if ($model->save()) {
            echo Json::encode('true');return;
        } else {
            echo Json::encode('false');return;
        }
    }
}

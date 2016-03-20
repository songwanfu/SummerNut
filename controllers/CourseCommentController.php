<?php

namespace app\controllers;

use Yii;
use app\models\CourseComment;
use app\models\Course;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * CourseCommentController implements the CRUD actions for CourseComment model.
 */
class CourseCommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'delete', 'add-jugement', 'add-comment', 'comment-up', 'comment-down'], 
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
     * Lists all CourseComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CourseComment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourseComment model.
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
     * Creates a new CourseComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseComment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CourseComment model.
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
     * Deletes an existing CourseComment model.
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
     * Finds the CourseComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseComment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddJugement()
    {
        $userId = Yii::$app->user->id;
        $courseId = Yii::$app->request->post('courseId');
        $content = Yii::$app->request->post('content');
        $score = Yii::$app->request->post('score');

        $model = new CourseComment();
        if ($model::isCommented($userId, $courseId)) {
            echo json_encode('false');
            return;
        } else {
            if ($model->addData($userId, $courseId, $content, $score, $model::COMMENT_TYPE_JUDGMENT)) {
                echo true;
                return;
            } else {
                echo false;
                return;
            }
        }
    }

    public function actionAddComment()
    {
        $userId = Yii::$app->user->id;
        $courseId = Yii::$app->request->post('courseId');
        $content = Yii::$app->request->post('content');
        $rootId = Course::findOneById($courseId)->root;

        $model = new CourseComment();
        if ($model->addData($userId, $courseId, $content, $model::SCORE_DEFAULT, $model::COMMENT_TYPE_COMMENT, $rootId)) {
            echo Json::encode('true');return;
        } else {
            echo Json::encode('false');return;
        }
    }

    public function actionCommentUp()
    {
        $commentId= Yii::$app->request->post('commentId');
        $model = $this->findModel($commentId);
        $model->up_count += 1;
        if ($model->save()) {
            echo Json::encode(true);return;
        } else {
            echo Json::encode(false);return;
        }
    }

    public function actionCommentDown()
    {
        $commentId= Yii::$app->request->post('commentId');
        $model = $this->findModel($commentId);
        $model->down_count += 1;
        if ($model->save()) {
            echo Json::encode(true);return;
        } else {
            echo Json::encode(false);return;
        }
    }
}

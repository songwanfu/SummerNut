<?php

namespace app\controllers;

use Yii;
use app\models\UserPlay;
use app\models\Nut;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\filters\AccessControl;
/**
 * UserPlayController implements the CRUD actions for UserPlay model.
 */
class UserPlayController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'delete', 'play-end', 'play-point'], 
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
     * Lists all UserPlay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UserPlay::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserPlay model.
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
     * Creates a new UserPlay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserPlay();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserPlay model.
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
     * Deletes an existing UserPlay model.
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
     * Finds the UserPlay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPlay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserPlay::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPlayEnd()
    {
        $userId = Yii::$app->user->id;
        $chapterId = Yii::$app->request->post('courseId');

        $userPlayModel = new UserPlay();
        $userPlayModel = $userPlayModel->findOneLearnModel($userId,$chapterId);
        $userPlayModel->learn_status = $userPlayModel::LEARN_STATUS_FINISH;

        if (!Nut::isGetNut($userId, $chapterId)) {
            Nut::addData($userId, $chapterId);
        }

        if ($userPlayModel->save()) {
            echo Json::encode('true');return;
        } else {
            echo Json::encode('false');return;
        }
    }

    public function actionPlayPoint()
    {
        $userId = Yii::$app->user->id;
        $chapterId = Yii::$app->request->post('courseId');
        $point = Yii::$app->request->post('point');

        $userPlayModel = new UserPlay();
        $userPlayModel = $userPlayModel->findOneLearnModel($userId,$chapterId);
        // if ($userPlayModel->learn_status == $userPlayModel::LEARN_STATUS_UN_FINISH) {
            $userPlayModel->learn_point = ceil($point);
        // }
        
        if ($userPlayModel->save()) {
            echo Json::encode('true');return;
        } else {
            echo Json::encode('false');return;
        }
    }
}

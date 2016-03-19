<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\Resource;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionZone()
    {
        $model = $this->currentUser();
        $htmlCourse = $this->render('/user/course', ['user' => $model]);
        return $this->render('zone', ['model' => $model, 'htmlCourse' => $htmlCourse]);
    }

    /**
     * [actionShowProfile 展示用户详细资料]
     * @return [type] [description]
     */
    public function actionShowProfile()
    {
        $model = $this->currentUser();
        $html = $this->render('/user/updateProfile', ['model' => $model]);
        return Json::encode($html);
    }

    public function actionShowQa()
    {
        $model = $this->currentUser();
        $html = $this->render('/user/qa', ['user' => $model]);
        return Json::encode($html);
    }

    /**
     * [actionUploadHeadPic 上传头像]
     * @return [type] [description]
     */
    public function actionUploadHeadPic()
    {
        $data = Yii::$app->request->post();
        $id = $data['User']['id'];
        $model = $this->findModel($id);
        $model->setScenario('profile');

        $resourceModel = new Resource();
        $model = $resourceModel->uploadImg($model, 'head_picture');
        if ($model) { 
            if ($model->save()) {
                 $res = [
                    'initialPreview' => '<p>' . Yii::t('app', 'Upload success!') . '</p>',
                ];
                echo json_encode($res);
            }
           
        }

    }

    /**
     * [actionUpdateProfile 更新用户详细资料]
     * @return [type] [description]
     */
    public function actionUpdateProfile()
    {
        $model = $this->currentUser();
        $username = Yii::$app->request->post('username');
        $model->email = Yii::$app->request->post('email');
        $model->signature = Yii::$app->request->post('signature');
        $model->sex = Yii::$app->request->post('sex');

        if ($username != $model->username) {
            if (User::findByUsername($username)) {
                echo Json::encode('用户名已被占用!');
                return;
            }
        }
        $model->username = $username;
        $model->setScenario('profile');
        if ($model->save()) {
            echo Json::encode('true');
        } else {
            echo Json::encode($model->errors);
        }
    }

    /**
     * [actionRefreshHeadPic 更换头像]
     * @return [type] [description]
     */
    public function actionRefreshHeadPic()
    {
        $model = $this->currentUser();
        $model->head_picture = Yii::$app->request->post('headPic');
        $model->setScenario('refreshHeadPic');
        if ($model->save()) {
            echo Json::encode('true');
        } else {
            echo Json::encode('false');
        }
    }

    protected function currentUser()
    {
        $userId = Yii::$app->user->id;
        return $this->findModel($userId);
    }
}

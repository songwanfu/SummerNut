<?php

namespace app\controllers;

use Yii;
use app\models\Resource;
use app\models\ResourceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ResourceController implements the CRUD actions for Resource model.
 */
class ResourceController extends Controller
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
     * Lists all Resource models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Resource model.
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
     * Creates a new Resource model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Resource();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Resource model.
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
     * Deletes an existing Resource model.
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
     * Finds the Resource model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resource the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resource::findOne($id)) !== null) {
            return $model;
        }
        return;
    }

    public function actionUpload()
    {
         // var_dump(Yii::$app->request->post());die;
        $model = new Resource();
        $model->load(Yii::$app->request->post());
        $model = $model->uploadFile($model, 'url');

        if ($model) {
            if ($model->save()) {
                 $res = [
                    'initialPreview' => '<p>' . Yii::t('app', 'Upload success!') . '</p>',
                ];
                echo json_encode($res);
            }
           
        }
       
    }

    public function actionPlay($id)
    {
        $model = $this->findModel($id);
        $model->play_count += 1;
        if ($model->save()) {
            return $this->render('play', ['url' => $model->url]);
        } 
    }

    public function actionPlayTime($duration)
    {
        var_dump($duration);
    }

    public function actionPlayEnd($duration)
    {
        var_dump($duration);
    }

    public function actionDeleteByAjax()
    {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        if ($model) {
            // $model->status = $model::STATUS_INVALID;
            // $model->resource_type = $model::TYPE_ATTACHMENT;
            // if ($model->save()) {
            //     echo true;
            //     return;
            // } 
            
            if ($model->delete()) {
                echo true;
                return;
            }
        }
        echo false;
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        $model->download_count += 1;
        if ($model->save()) {
            return Yii::$app->response->sendFile(Yii::$app->params['uploadUrl'] . $model->url);
        }
        
    }

    public function actionTranscode()
    {
        $model = new Resource();

        //如果数据库还有需要转码的视频,取一条记录开始转码
        while ($model->findOneTranscodeVideo()) {
            $video = $model->findOneTranscodeVideo();
            if (!$model->transcode($video)) {
                Yii::error("$video->update_time---$video->name transcode failed", 'error');
                break;
            }
        }
        
    }
}

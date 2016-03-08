<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Course;
use app\models\Resource;
use app\models\Common;
use yii\helpers\Json;
use yii\helpers\HtmlPurifier;
use kartik\markdown\Markdown;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $course_id = Yii::$app->request->get('course_id');
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $course_id);

        $chapterName = $courseName = null;
        if (!empty($course_id)) {
            $chapterName = Course::findModel($course_id)->name; 
            $courseName = Course::findRoot($course_id)->name; 
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'courseId' => $course_id,
            'chapterName' => $chapterName,
            'courseName' => $courseName,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $course_id = Yii::$app->request->get('course_id');

        $model = new Task();

        if ($model->load(Yii::$app->request->post())) {
            $model = $model->validateAttr($model);
            if (empty($model->errors)) {
                $resourceModel = new Resource();
                $model = $resourceModel->uploadImg($model, 'image');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        $model->course_id = $course_id;
        if (!json_decode($model->answer_json)) {
            $model->answer_json = '';
        }

        $chapterName = $courseName = null;
        if (!empty($course_id)) {
            $chapterName = Course::findModel($course_id)->name; 
            $courseName = Course::findRoot($course_id)->name; 
        }

        return $this->render('create', [
            'model' => $model,
            'courseId' => $course_id,
            'chapterName' => $chapterName,
            'courseName' => $courseName,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model = $model->validateAttr($model);
            if (empty($model->errors)) {
                $resourceModel = new Resource();
                $model = $resourceModel->uploadImg($model, 'image');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        if ($model->is_timing == $model::IS_NOT_TIMING) {
            $model->complete_time = '00:00';
        }

        if ($model->task_type == $model::TYPE_CHOICE) {
            $optionArr = json_decode($model->option_json, true);
            // var_dump($optionArr);die;
            foreach ($optionArr as $k => $v) {
                $index = 'option_' . $k;
                $model->$index = $v;
            }
            

            $model->answer_choice = json_decode($model->answer_json, true);

            return $this->render('update-choice', ['model' => $model]);
        }

        if ($model->task_type == $model::TYPE_SHORT_ANSWER || $model->task_type == $model::TYPE_CALCULATION) {
            

            return $this->render('update-short-calculation', ['model' => $model]);
        }


        

        
    }

    /**
     * Deletes an existing Task model.
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
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPreview()
    {
        $module = Yii::$app->getModule('markdown');
        if (\Yii::$app->user->can('smarty')) {
            $module->smarty = true;
            $module->smartyYiiApp = \Yii::$app->user->can('smartyYiiApp') ? true : false;
            $module->smartyYiiParams = Yii::$app->user->can('smartyYiiParams') ? true : false;
        }
        if (isset($_POST['source'])) {
            $output = (strlen($_POST['source']) > 0) ? Markdown::convert($_POST['source'], ['custom' => $module->customConversion]) : $_POST['nullMsg'];
        }
        echo Json::encode(HtmlPurifier::process($output));
    }

}

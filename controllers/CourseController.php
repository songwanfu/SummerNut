<?php
namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Course;
use app\models\Resource;
use app\models\Category;
use app\models\UserCourse;
use app\models\Question;
use app\models\User;

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
                            'actions' => ['create', 'list', 'view', 'learn', 'comment', 'manage', 'qa', 'update', 'delete', 'test', 'upload', 'delete-icon', 'qadetail'], 
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['list', 'view', 'learn', 'comment', 'qa'], 
                            'roles' => ['?'],
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

    public function actionList()
    {
        $course = Yii::$app->request->get('c');
        $difficulty_level = Yii::$app->request->get('is_easy');
        // $sort = Yii::$app->request->get('sort');

        $newCourseList = [];//获取最新的课程列表
        $hotCourseList = [];//获取最热的课程列表
        $showCategoryList = [];//该方向下的所有列表
        $activeDirection = '';//点击的方向
        $activeCategoryList = [];//需要搜索的列表
        $activeCategory = '';//点击的分类名称
        $activeDifficulty = '';//点击的课程程度

        if (!empty($course)) {
            //如果course在方向列表中,则获取分类列表;如果在分类列表里,则
            if (in_array($course, Category::$direction)) {
                $activeDirection = $course;//将搜索的方向设为active
                $aliasList = Category::directionAliasList();
                $directionId = $aliasList[$course];
                $showCategoryList = Category::findModelsByDirection($directionId);//该方向下的所有列表
                $activeCategoryList = $showCategoryList;//需要搜索的列表
            } else if (in_array($course, Category::aliasList())) {
                $directionId = Category::getDirectionByAlias($course)->direction;//该分类所在的方向ID
                $directionAliasFlipList = Category::directionAliasFlipList();
                $activeDirection = $directionAliasFlipList[$directionId];//获取active方向名称

                $showCategoryList = Category::findModelsByDirection($directionId);//该方向下的所有列表

                $activeCategoryList = Category::findModelByAlias($course);//只有一个对象的对象数组
                $activeCategory = $course;//点击的分类名称
            } else {
                $course = '';
            }

            //如果不为空则获取课程列表
            if (!empty($activeCategoryList)) {
                foreach ($activeCategoryList as $category) {
                    $newCourseList[] = Course::queryCourse($category->id, $difficulty_level, 'new');
                    $hotCourseList[] = Course::queryCourse($category->id, $difficulty_level, 'hot');
                }
            } 
        }

        //course为空;获取全部课程列表
        if (empty($course)) {
            $showCategoryList = Category::findAllModels();
            $newCourseList[] = Course::queryCourse('', $difficulty_level, 'new');
            $hotCourseList[] = Course::queryCourse('', $difficulty_level, 'hot');
        }
        


        
        if (!empty($difficulty_level)) {
            $activeDifficulty = $difficulty_level;
        }

        return $this->render('list', [
            'c' => $course,
            'is_easy' => $difficulty_level,
            'newCourseList' => array_filter($newCourseList),
            'hotCourseList' => array_filter($hotCourseList),
            'activeDirection' => $activeDirection,
            'activeCategory' => $activeCategory,
            'showCategoryList' => $showCategoryList,
            'activeDifficulty' => $activeDifficulty,
        ]);
    }

    public function actionView()
    {
        $courseId = Yii::$app->request->get('cid');
        $isLearn = false;
        $model = $this->findModelByCoursId($courseId);
        $categoryModel = Category::findOneById($model->category);
        if (empty($model)) {
            $this->goBack(Yii::$app->request->headers['Referer']);
            return;
        } else {
            $videoCount = Course::fileCount($model->id);
            if (UserCourse::isLearn(Yii::$app->user->id, $courseId)) {
                $isLearn = true;
            }
            return $this->render('view', ['course' => $model, 'isLearn' => $isLearn, 'categoryModel' => $categoryModel, 'videoCount' => $videoCount]);
        }
    }

    protected function findModelByCoursId($courseId)
    {
        //如果没有找到这门课则返回null
        $model = Course::findOneById($courseId);
        if (empty($model) || !Course::isRoot($model)) {
            return null;
        } 
        return $model;
    }

    public function actionLearn()
    {
        $courseId = Yii::$app->request->get('cid');
        $model = $this->findModelByCoursId($courseId);
        $categoryModel = Category::findOneById($model->category);
        $isLearn = false;

        if (UserCourse::isLearn(Yii::$app->user->id, $courseId)) {
            $isLearn = true;
        } else {
            UserCourse::addData(Yii::$app->user->id, $courseId, UserCourse::TYPE_LEARN);
            $model->learner_count += 1;
            $model->save();
            $isLearn = true;
        }
        return $this->render('learn', ['course' => $model, 'categoryModel' => $categoryModel, 'isLearn' => $isLearn]);
    }

    public function actionComment()
    {
        $courseId = Yii::$app->request->get('cid');
        $model = $this->findModelByCoursId($courseId);
        // var_dump($model);die;
        $categoryModel = Category::findOneById($model->category);
        $isLearn = false;

        if (UserCourse::isLearn(Yii::$app->user->id, $courseId)) {
            $isLearn = true;
        } 
        return $this->render('comment', ['course' => $model, 'categoryModel' => $categoryModel, 'isLearn' => $isLearn]);
    }

    public function actionQa()
    {
        $courseId = Yii::$app->request->get('cid');
        $model = $this->findModelByCoursId($courseId);
        // var_dump($model);die;
        $categoryModel = Category::findOneById($model->category);
        $isLearn = false;

        if (UserCourse::isLearn(Yii::$app->user->id, $courseId)) {
            $isLearn = true;
        } 
        return $this->render('qa', ['course' => $model, 'categoryModel' => $categoryModel, 'isLearn' => $isLearn]);
    }

    public function actionManage()
    {
        return $this->render('manage');
    }

    public function actionQadetail()
    {
        $questionModel = Question::findModel(Yii::$app->request->get('qid'));
        $courseModel = Course::findOneById($questionModel->course_id);
        $userModel = User::findModel($questionModel->user_id);

        $questionModel->views += 1;
        $questionModel->save();
        
    	return $this->render('qadetail', ['question' => $questionModel, 'course' => $courseModel, 'user' => $userModel]);
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

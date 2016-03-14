<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\user;
use app\models\SignupForm;
use yii\helpers\Json;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        // echo 1;die;
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {   
            return $this->goHome();
        }
    
        $model = new User();
        $model->setScenario('login');

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new User();
        $model->setScenario('signup');
        if ($model->load(Yii::$app->request->post())) { 
            if ($model->save()) {
                if ($model->type == $model::TYPE_TEACHER) {
                    return $this->render('authen', ['message' => $model->username]);
                }
                return $this->redirect(['login']);
            }   
        }
        
        $model->type = $model::TYPE_STUDENT;
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionLanguage()
    {
        $language = Yii::$app->language;

        if ($language == 'en-US') {
            $language = 'zh-CN';
        } else {
            $language = 'en-US';
        }

        #use cookie to store language
        $lang_cookie = new yii\web\Cookie(['name' => 'language', 'value' => $language, 'expire' => 3600*24*30,]);
        $lang_cookie->expire = time() + 3600*24*30;
        Yii::$app->response->cookies->add($lang_cookie);

        Yii::$app->language = $language;
        $this->goBack(Yii::$app->request->headers['Referer']);
    }

    public function actionTest()
    {
        $html = $this->render('/user/create', ['model' => 1]);
        return Json::encode($html);
    }
}

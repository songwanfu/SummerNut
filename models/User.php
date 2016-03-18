<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Common;

/**
 * This is the model class for table "t_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $head_picture
 * @property string $accessToken
 * @property string $authKey
 * @property integer $sex
 * @property string $phone_number
 * @property string $faculty
 * @property string $signature
 * @property integer $type
 * @property integer $status
 * @property string $login_ip
 * @property string $register_time
 * @property string $login_time
 */
class user extends ActiveRecord implements IdentityInterface
{
    const SEX_FEMALE = 1;//男性
    const SEX_MALE = 2;//女性
    const SEX_SECRET = 3;//保密
    const TYPE_STUDENT = 1;//学生
    const TYPE_TEACHER = 2;//教师
    const STATUS_NORMAL = 1;//正常
    const STATUS_ABNORMAL = 2;//异常
    const STATUS_AUTHEN = 3;//认证

    public $password_repeat;
    public $rememberMe = true;
    private $_user = false;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_user';
    }

    public function scenarios()
    {
        return [
            'login' => ['username', 'password', 'login_time', 'login_ip'],
            'signup' => ['username', 'password', 'password_repeat', 'email', 'rememberMe', 'type', 'status', 'register_time', 'login_time', 'login_ip', 'sex'],
            'profile' => ['username', 'email', 'sex', 'head_picture', 'phone_number', 'faculty', 'signature'],
            'refreshHeadPic' => ['head_picture'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['sex', 'type', 'status'], 'integer'],
            [['register_time', 'login_time'], 'safe'],
            ['username', 'string', 'min' => 3, 'max' => 16],
            ['password', 'string', 'min' => 6, 'max' => 16],
            [['email', 'head_picture', 'accessToken', 'authKey', 'signature'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 11],
            [['faculty'], 'string', 'max' => 20],
            [['login_ip'], 'string', 'max' => 15],
            ['sex', 'default', 'value' => self::SEX_FEMALE],
            ['type', 'default', 'value' => self::TYPE_STUDENT],
            ['status', 'default', 'value' => self::STATUS_NORMAL],
            ['login_ip', 'default', 'value' => self::getIp()],
            [['login_time', 'register_time'], 'default', 'value' => Common::getTime()],
            ['username', 'unique', 'on' => 'signup'],
            ['password', 'compare', 'on' => 'signup'],
            ['password', 'match', 'pattern' => '/^[A-Za-z0-9\-_]+$/', 'on' => 'signup','message' => '{attribute}为字母,数字和下划线组成'],
            ['password', 'validatePassword', 'on' => 'login'],
            ['email', 'email', 'on' => 'signup'],
            ['email', 'email', 'on' => 'profile'],
            ['rememberMe', 'boolean', 'on' => 'signup'],
            ['head_picture', 'file', 'extensions' => ['png', 'jpg', 'jpeg'], 'maxSize' => 1024*1024*1024, 'on' => 'profile'],
            ['head_picture', 'string', 'min' => 3, 'max' => 255, 'on' => 'refreshHeadPic'],
        ];
    }

    public function afterValidate()
    {
        if ($this->getScenario() == 'signup') {
            parent::afterValidate();
            $this->setPassword($this->password);
        }
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
            'email' => Yii::t('app', 'Email'),
            'head_picture' => Yii::t('app', 'Head Picture'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'sex' => Yii::t('app', 'Sex'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'faculty' => Yii::t('app', 'Faculty'),
            'signature' => Yii::t('app', 'Signature'),
            'type' => Yii::t('app', 'User Type'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
            'status' => Yii::t('app', 'Status'),
            'login_ip' => Yii::t('app', 'Login Ip'),
            'register_time' => Yii::t('app', 'Register Time'),
            'login_time' => Yii::t('app', 'Login Time'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }


    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * [getIp Get user IP adress.]
     * @return [String] [IP adress]
     */
    public static function getIp()
    {
        return Yii::$app->request->userIP;
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = self::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * [typeList Get user type list.]
     * @return [Array] [UserTypeList]
     */
    public function typeList()
    {
        return [
            self::TYPE_STUDENT => Yii::t('app', 'Student'), 
            self::TYPE_TEACHER => Yii::t('app', 'Teacher'),
        ];
    }

    public function sexList()
    {
        return [
            static::SEX_FEMALE => Yii::t('app', 'Female'),
            static::SEX_MALE => Yii::t('app', 'Male'),
            static::SEX_SECRET => Yii::t('app', 'Secret'),
        ];
    }

    public static function findModel($id)
    {
        return static::findOne(['id' => $id]);
    }


}

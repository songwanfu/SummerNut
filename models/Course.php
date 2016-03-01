<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_product".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $name
 * @property string $icon
 * @property integer $icon_type
 * @property integer $active
 * @property integer $selected
 * @property integer $disabled
 * @property integer $readonly
 * @property integer $visible
 * @property integer $collapsed
 * @property integer $movable_u
 * @property integer $movable_d
 * @property integer $movable_l
 * @property integer $movable_r
 * @property integer $removable
 * @property integer $removable_all
 */
class Course extends \kartik\tree\models\Tree
{
    const LEVEL_ELEMENTARY = 1;
    const LEVEL_INTERMEDIATE = 2;
    const LEVEL_ADVANCED = 3;
    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;

    public $url;
    // public $icon;
    // public $number;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules_parent = parent::rules();
        $rules_course = [
            [['difficulty_level', 'teacher_id', 'status', 'introduction', 'notice', 'gains'], 'safe'],
            [['teacher_id', 'status'], 'integer'],
            [['introduction', 'notice', 'gains'], 'string', 'max' => 500],
            ['teacher_id', 'default', 'value' => Yii::$app->user->id],
            ['difficulty_level', 'default', 'value' => self::LEVEL_ELEMENTARY],
            ['status', 'default', 'value' => self::STATUS_VALID]
        ];
        return array_merge($rules_parent, $rules_course);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels_parent = parent::attributeLabels();
        $labels_course = [
            'difficulty_level' => Yii::t('app', 'Diffculty Level'),
            'status' => Yii::t('app', 'Status'),
            'introduction' => Yii::t('app', 'Course Introduction'),
            'notice' => Yii::t('app', 'Course Notice'),
            'gains' => Yii::t('app', 'Course Gains'),
        ];
        
        return array_merge($labels_parent, $labels_course);
    }

    public function isDisabled()
    {
        // if (Yii::$app->user->username !== 'admin') {
        //     return true;
        // }
        return parent::isDisabled();
    }

    public static function levelList()
    {
        return [
            self::LEVEL_ELEMENTARY => Yii::t('app', 'Elementary'),
            self::LEVEL_INTERMEDIATE => Yii::t('app', 'Intermediate'),
            self::LEVEL_ADVANCED => Yii::t('app', 'Advanced'),
        ];
    }

    public static function statusList()
    {
        return [
            self::STATUS_VALID => Yii::t('app', 'Online'),
            self::STATUS_INVALID => Yii::t('app', 'Offline'),
        ];
    }

    public static function maxDepth()
    {
        return self::find()->max('lvl');
    }


    /**
     * [isFile 判断是否是文件]
     * @param  Course  $model [description]
     * @return boolean        [description]
     */
    public static function isFile(Course $model)
    {
        if ($model->rgt - $model->lft == 1) {
            return true;
        }
        return false;
    }

}

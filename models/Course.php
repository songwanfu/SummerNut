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

    public static $iconFormats = ['jpg', 'jpeg', 'png'];
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
            [['category', 'difficulty_level', 'teacher_id', 'status', 'leaner_count', 'introduction', 'notice', 'gains', 'create_time', 'update_time'], 'safe'],
            [['teacher_id', 'status', 'category', 'leaner_count'], 'integer'],
            [['introduction', 'notice', 'gains'], 'string', 'max' => 500],
            ['teacher_id', 'default', 'value' => Yii::$app->user->id],
            ['difficulty_level', 'default', 'value' => static::LEVEL_ELEMENTARY],
            ['status', 'default', 'value' => static::STATUS_VALID],
            ['icon', 'file', 'extensions' => static::$iconFormats],
            [['create_time', 'update_time'], 'default', 'value' => Common::getTime()],
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
            'leaner_count' => Yii::t('app', 'Learner Count'),
            'introduction' => Yii::t('app', 'Course Introduction'),
            'notice' => Yii::t('app', 'Course Notice'),
            'gains' => Yii::t('app', 'Course Gains'),
            'category' => Yii::t('app', 'Course Category'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
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
            static::LEVEL_ELEMENTARY => Yii::t('app', 'Elementary'),
            static::LEVEL_INTERMEDIATE => Yii::t('app', 'Intermediate'),
            static::LEVEL_ADVANCED => Yii::t('app', 'Advanced'),
        ];
    }

    public static function statusList()
    {
        return [
            static::STATUS_VALID => Yii::t('app', 'Online'),
            static::STATUS_INVALID => Yii::t('app', 'Offline'),
        ];
    }

    public static function maxDepth()
    {
        return static::find()->max('lvl');
    }


    /**
     * [isFile 判断是否是文件]
     * @param  Course  $model [description]
     * @return boolean        [description]
     */
    public static function isFile($model = null)
    {
        if ($model == null) return false;

        if ($model->rgt - $model->lft == 1) {
            return true;
        }
        return false;
    }

    public static function isRoot($model = null)
    {
        if ($model == null) return false;

        if ($model->lvl == 0) {
            return true;
        }
        return false;
    }

    public static function findModel($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findRoot($id)
    {
        return static::findModel(static::findModel($id)->root);
    }

    public static function fileMap($fieldArr = [])
    {
        $fieldStr = strtolower(implode(',', $fieldArr));

        $sql = "SELECT {$fieldStr} FROM t_course WHERE rgt - lft = 1";
        $models = static::findBySql($sql)->asArray()->all();
        $map = [];
        $i = 0;
        foreach ($models as $model) {
            foreach ($fieldArr as $field) {
                $map[$i][$field]  = $model[$field];
            }
            $i++;
        }
        return $map;
    }


    public static function findRootByCategory($categoryId)
    {
        return static::find()->where(['lvl' => 0, 'category' => $categoryId])->all();
    }

    public static function findModels($field = [], $condition = [], $sort = '')
    {
        return static::find($field)->where($condition)->orderBy($sort)->all();
    }

    public static function queryCourse($category = '', $difficulty_level = '', $sort = 'update_time DESC')
    {
        $condition = [];

        if (!empty($category) && empty($difficulty_level)) {
            $condition = ['lvl' => 0, 'category' => $category];
        }

        if (empty($category) && !empty($difficulty_level)) {
            $condition = ['lvl' => 0, 'difficulty_level' => $difficulty_level];
        }

        if (!empty($category) && !empty($difficulty_level)) {
            $condition = ['lvl' => 0, 'category' => $category, 'difficulty_level' => $difficulty_level];
        }    

        return static::findModels(['id', 'name', 'icon', 'difficulty_level', 'learner_count', 'introduction'], $condition, $sort);
        
    }

}

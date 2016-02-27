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

    // public $icon;
    // public $number;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules_course = [
            [['difficulty_level', 'teacher_id'], 'safe'],
            ['teacher_id', 'integer'],
            ['teacher_id', 'default', 'value' => Yii::$app->user->id],
            ['difficulty_level', 'default', 'value' => self::LEVEL_ELEMENTARY],
        ];
        return array_merge($rules, $rules_course);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $difficultyLevelAttribute = $teacherAttribute = null;
        $labels_course = [
            $difficultyLevelAttribute => Yii::t('app', 'Diffculty Level'),
            $teacherAttribute => Yii::t('app', 'Teacher'),
        ];
        
        return array_merge($labels, $labels_course);
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

}

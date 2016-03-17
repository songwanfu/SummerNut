<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "r_user_course".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $type
 * @property string $create_time
 */
class UserCourse extends \yii\db\ActiveRecord
{
    const TYPE_LEARN = 1;
    const TYPE_FOCUS = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_user_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id', 'type'], 'required'],
            [['user_id', 'course_id', 'type'], 'integer'],
            [['create_time'], 'safe'],
            ['create_time', 'default', 'value' => Common::getTime()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'type' => Yii::t('app', 'Type'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    public function findModels($field = [], $condition = [])
    {
        return static::find($field)->where($condition)->all();
    }

    public function isLearn($userId, $courseId)
    {
        return (empty(static::findModels([], ['user_id' => $userId, 'course_id' => $courseId, 'type' => static::TYPE_LEARN])) ? false : true);
    }

    public static function isFocus($userId, $courseId)
    {
        return (empty(static::findModels([], ['user_id' => $userId, 'course_id' => $courseId, 'type' => static::TYPE_FOCUS])) ? false : true);
    }

    public static function addData($userId, $courseId, $type = self::TYPE_LEARN)
    {
        $model = new self();
        $model->user_id =  $userId;
        $model->course_id = $courseId;
        $model->type = $type;
        if ($model->save()) {
            return true;
        }  
        return false;
    }

    public static function deleteData($condition = [])
    {
        $models = static::find($condition)->all();
        foreach ($models as $model) {
            if (!$model->delete()) return false;
        }
        return true;
    }

    public static function deleteFocus($userId, $courseId, $type)
    {
        return static::deleteData(['user_id' => $userId, 'course_id' => $courseId, 'type' => $type]);
    }
}

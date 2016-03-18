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
 * @property integer $learn_status
 * @property integer $learn_time_total
 * @property string $learn_time
 * @property string $create_time
 */
class UserCourse extends \yii\db\ActiveRecord
{
    const TYPE_LEARN = 1;
    const TYPE_FOCUS = 2;
    const LEARN_STATUS_NOT_FINISH = 1;
    const LEARN_STATUS_FINISHED = 2;
    const LEARN_TIME_TOTAL_DEFAULT= 0;
    const LEARN_TIME_DEFAULT = 0;
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
            [['user_id', 'course_id', 'type', 'learn_status', 'learn_time_total'], 'integer'],
            [['learn_time', 'create_time'], 'safe'],
            ['create_time', 'default', 'value' => Common::getTime()],
            ['type', 'default', 'value' => self::TYPE_LEARN],
            ['learn_status', 'default', 'value' => self::LEARN_STATUS_NOT_FINISH],
            ['learn_time_total', 'default', 'value' => self::LEARN_TIME_TOTAL_DEFAULT],
            ['learn_time', 'default', 'value' => Common::getTime()]
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
            'learn_status' => Yii::t('app', 'Learn Status'),
            'learn_time_total' => Yii::t('app', 'Learn Time Total'),
            'learn_time' => Yii::t('app', 'Learn Time'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }


    public function findModels($field = [], $condition = [])
    {
        return static::find($field)->where($condition)->all();
    }

    public static function isLearn($userId, $courseId)
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

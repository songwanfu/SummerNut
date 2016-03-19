<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_nut".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $nut_count
 * @property string $create_time
 * @property string $update_time
 */
class Nut extends \yii\db\ActiveRecord
{
    const NUT_COUNT_DEFAULT = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_nut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id'], 'required'],
            [['user_id', 'course_id', 'nut_count'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            ['nut_count', 'default', 'value' => self::NUT_COUNT_DEFAULT],
            [['create_time', 'update_time'], 'default', 'value' => Common::getTime()],
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
            'nut_count' => Yii::t('app', 'Nut Count'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public static function isGetNut($userId, $courseId)
    {
        return empty(static::findOne(['user_id' => $userId, 'course_id' => $courseId])) ? false : true;
    }

    public static function nutCount($userId)
    {
        return count(static::findAll(['user_id' => $userId]));
    }

    public static function addData($userId, $courseId)
    {
        $model = new self();
        $model->user_id = $userId;
        $model->course_id = $courseId;
        if ($model->save()) {
            return true;
        } 
        return false;
    }
}

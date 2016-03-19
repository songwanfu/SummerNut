<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_question".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $content
 * @property integer $course_id
 * @property integer $root_id
 * @property string $create_time
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content', 'course_id', 'root_id'], 'required'],
            [['user_id', 'course_id', 'root_id', 'views'], 'integer'],
            [['content'], 'string'],
            [['create_time'], 'safe'],
            ['create_time', 'default' ,'value' => Common::getTime()]
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
            'content' => Yii::t('app', 'Content'),
            'course_id' => Yii::t('app', 'Course ID'),
            'root_id' => Yii::t('app', 'Root ID'),
            'views' => Yii::t('app', 'Views'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    public function addData($userId, $content, $courseId)
    {
        $model = new self();
        $model->user_id = $userId;
        $model->content = $content;
        $model->course_id = $courseId;
        $model->root_id = Course::findOneById($courseId)->root;
        if ($model->save()) {
            return true;
        }
        return false;
    }

    public static function getQuestionList($courseId)
    {
        $courseModel = Course::findOneById($courseId);
        if (Course::isRoot($courseModel)) {
            return static::find(['root_id' => $courseId])->orderBy('create_time DESC')->all();
        }

        if (Course::isFile($courseModel)) {
            return static::find(['course_id' => $courseId])->orderBy('create_time DESC')->all();
        }
    }

    public static function findModel($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function myQuestion($userId)
    {
        return static::find()->where(['user_id' => $userId])->orderBy('create_time')->all();
    }
}

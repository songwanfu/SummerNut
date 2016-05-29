<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_answer".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $content
 * @property integer $answer_user_id
 * @property integer $answered_user_id
 * @property integer $asker_status
 * @property integer $reply_status
 * @property string $create_time
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'content', 'answer_user_id', 'answered_user_id'], 'required'],
            [['question_id', 'answer_user_id', 'answered_user_id', 'asker_status', 'reply_status'], 'integer'],
            [['content'], 'string'],
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
            'question_id' => Yii::t('app', 'Question ID'),
            'content' => Yii::t('app', 'Content'),
            'answer_user_id' => Yii::t('app', 'Answer User ID'),
            'answered_user_id' => Yii::t('app', 'Answered User ID'),
            'asker_status' => Yii::t('app', 'Asker Status'),
            'reply_status' => Yii::t('app', 'Reply Status'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    public function addData($questionId, $content, $answerUserId, $answeredUserId)
    {
        $model = new self();
        $model->question_id = $questionId;
        $model->content = $content;
        $model->answer_user_id = $answerUserId;
        $model->answered_user_id = $answeredUserId;
        if ($model->save()) {
            return true;
        }
        return false;
    }

    public static function replyList($questionId)
    {
        return static::findAll(['question_id' => $questionId]);
    }

    public static function replyLatest($questionId)
    {
        $data = static::find()->where(['question_id' => $questionId])->orderBy('create_time DESC')->limit(1)->all();
        if (empty($data)) {
            return null;
        } else {
            return $data[0];
        }

    }

    public static function myReplyList($userId)
    {
        return static::find()->where(['answer_user_id' => $userId])->orderBy('create_time DESC')->all();
    }

}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "r_user_play".
 *
 * @property integer $id
 * @property integer $chapter_id
 * @property integer $user_id
 * @property integer $learn_status
 * @property integer $learn_time_total
 * @property string $learn_time
 * @property integer $learn_point
 */
class UserPlay extends \yii\db\ActiveRecord
{
    const LEARN_STATUS_UN_FINISH = 1;
    const LEARN_STATUS_FINISH = 2;
    const LEARN_TIME_TOTAL_DEFAULT = 0;
    const LEARN_PONIT_DEFAULT = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_user_play';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chapter_id', 'user_id', 'learn_status'], 'required'],
            [['chapter_id', 'user_id', 'learn_status', 'learn_time_total', 'learn_point'], 'integer'],
            [['learn_time'], 'safe'],
            ['learn_time_total', 'default', 'value' => self::LEARN_TIME_TOTAL_DEFAULT],
            ['learn_time', 'default', 'value' => Common::getTime()],
            ['learn_point', 'default', 'value' => self::LEARN_PONIT_DEFAULT],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chapter_id' => Yii::t('app', 'Chapter ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'learn_status' => Yii::t('app', 'Learn Status'),
            'learn_time_total' => Yii::t('app', 'Learn Time Total'),
            'learn_time' => Yii::t('app', 'Learn Time'),
            'learn_point' => Yii::t('app', 'Learn Point'),
        ];
    }

    public function addData($userId, $chapterId)
    {
        $model = new self();
        $model->chapter_id = $chapterId;
        $model->user_id = $userId;
        $model->learn_status = self::LEARN_STATUS_UN_FINISH;
        if ($model->save()) {
            return true;
        } 
        return false;

    }

    public function isLearn($userId, $chapterId)
    {
        return empty(static::findOne(['user_id' => $userId, 'chapter_id' => $chapterId])) ? false : true;
    }

    public function findOneLearnModel($userId, $chapterId)
    {
        return static::findOne(['user_id' => $userId, 'chapter_id' => $chapterId]);
    }

    public static function getLearnPercent($userId, $courseId)
    {
        $fileCount = Course::fileCount($courseId);

        $userPlayModels = static::findAll(['user_id' => $userId, 'learn_status' => self::LEARN_STATUS_FINISH]);
        $count = 0;
        foreach ($userPlayModels as $userPlayModel) {
            if (Course::findOneById($userPlayModel->chapter_id)->root == $courseId) {
                $count++;
            }
        }
        return round($count / $fileCount, 2);
    }


}

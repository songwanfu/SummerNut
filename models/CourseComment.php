<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_course_comment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property string $content
 * @property integer $score
 * @property integer $up_count
 * @property integer $down_count
 * @property string $comment_time
 */
class CourseComment extends \yii\db\ActiveRecord
{
    const SCORE_DEFAULT = 0;
    const UP_COUNT_DEFAULT = 0;
    const DOWN_COUNT_DEFAULT = 0;
    const COMMENT_TYPE_COMMENT = 1;
    const COMMENT_TYPE_JUDGMENT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_course_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id', 'content'], 'required'],
            [['user_id', 'course_id', 'score', 'up_count', 'down_count', 'comment_type', 'root_id'], 'integer'],
            [['comment_time'], 'safe'],
            [['content'], 'string', 'max' => 255],
            ['comment_time', 'default', 'value' => Common::getTime()],
            ['comment_type', 'default', 'value' => self::COMMENT_TYPE_COMMENT],

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
            'root_id' => Yii::t('app', 'Root ID'),
            'content' => Yii::t('app', 'Content'),
            'score' => Yii::t('app', 'Score'),
            'up_count' => Yii::t('app', 'Up Count'),
            'down_count' => Yii::t('app', 'Down Count'),
            'comment_type' => Yii::t('app', 'Comment Type'),
            'comment_time' => Yii::t('app', 'Comment Time'),
        ];
    }

    public static function isCommented($userId, $courseId)
    {
        return static::findOne(['user_id' => $userId, 'course_id' => $courseId, 'comment_type' => self::COMMENT_TYPE_JUDGMENT]) == null ? false : true;
    }

    public function addData($userId, $courseId, $content, $score = self::SCENARIO_DEFAULT, $commentType = self::COMMENT_TYPE_COMMENT, $rootId = '', $up_count = self::UP_COUNT_DEFAULT, $down_count = self::DOWN_COUNT_DEFAULT)
    {
        $model = new self();
        $model->user_id = $userId;
        $model->course_id = $courseId;
        $model->content = $content;
        $model->score = $score;
        $model->comment_type = $commentType;
        $model->root_id = $rootId;
        $model->up_count = $up_count;
        $model->down_count = $down_count;
        if ($model->save()) {
            return true;
        }
        return false;
    }

    public static function courseAvgScore($courseId)
    {
        $sql = "SELECT AVG(score) AS avgScore FROM t_course_comment WHERE course_id = {$courseId} AND comment_type = 2";
        return static::findBySql($sql)->asArray()->all();
    }

    public static function judgmentList($courseId)
    {
        return static::findAll(['course_id' => $courseId, 'comment_type' => self::COMMENT_TYPE_JUDGMENT]);
    }

    public static function findOneById($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function commentList($courseId)
    {
        $courseModel = Course::findModel($courseId);
        if (Course::isFile($courseModel)) {
            return static::findAll(['course_id' => $courseId, 'comment_type' => self::COMMENT_TYPE_COMMENT]);
        } 

        if (Course::isRoot($courseModel)) {
            return static::findAll(['root_id' => $courseId, 'comment_type' => self::COMMENT_TYPE_COMMENT]);
        }
        
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_task".
 *
 * @property integer $id
 * @property integer $course_id
 * @property string $title
 * @property string $option_json
 * @property string $answer_json
 * @property string $image
 * @property integer $score
 * @property integer $task_type
 * @property integer $is_timing
 * @property string $complete_time
 * @property string $create_time
 * @property string $update_time
 */
class Task extends \yii\db\ActiveRecord
{
    const TYPE_CHOICE = 1;//选择题
    const TYPE_TRUE_FALSE = 2;//判断题
    const TYPE_SHORT_ANSWER = 3;//简答题
    const TYPE_CALCULATION = 4;//计算题
    const TYPE_CODING = 5;//编程题
    const IS_TIMING = 1;//计时
    const IS_NOT_TIMING = 0;//不计时

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'title', 'score'], 'required'],
            [['course_id', 'score', 'task_type', 'is_timing'], 'integer'],
            [['title', 'option_json'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['answer_json', 'image'], 'string', 'max' => 255],
            [['complete_time'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'title' => Yii::t('app', 'Task Title'),
            'option_json' => Yii::t('app', 'Option Json'),
            'answer_json' => Yii::t('app', 'Answer Json'),
            'image' => Yii::t('app', 'Task Image'),
            'score' => Yii::t('app', 'Total Score'),
            'task_type' => Yii::t('app', 'Task Type'),
            'is_timing' => Yii::t('app', 'Is Timing'),
            'complete_time' => Yii::t('app', 'Complete Time'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public static function timingList()
    {
        return [
            self::IS_NOT_TIMING => Yii::t('app', 'Not Timing'),
            self::IS_TIMING => Yii::t('app', 'Timing'),
        ];
    }

    public static function typeList()
    {
        return [
            self::TYPE_CHOICE => Yii::t('app', 'Task Choice'),
            self::TYPE_TRUE_FALSE => Yii::t('app', 'Task True Or False'),
            self::TYPE_SHORT_ANSWER => Yii::t('app', 'Task Short Answer'),
            self::TYPE_CALCULATION => Yii::t('app', 'Task Calculation'),
            self::TYPE_CODING => Yii::t('app', 'Task Coding'),
        ];
    }

    public static function scoreList()
    {
        return [1, 2, 3, 4, 5];
    }

    public static function timeList()
    {
        return ['00:30', '01:00', '01:30', '02:00', '03:00', '05:00', '10:00', '15:00', '20:00', '30:00', '40:00', '50:00', '60:00'];
    }
}

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
    const TYPE_SHORT_ANSWER = 2;//简答题
    const TYPE_CALCULATION = 3;//计算题
    const TYPE_CODING = 4;//编程题
    const IS_TIMING = 1;//计时
    const IS_NOT_TIMING = 0;//不计时

    public $option_A;
    public $option_B;
    public $option_C;
    public $option_D;
    public $answer_choice;
    public $code_test_one_input;
    public $code_test_two_input;
    public $code_test_three_input;
    public $code_test_one_output;
    public $code_test_two_output;
    public $code_test_three_output;

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
            [['option_A', 'option_B', 'option_C', 'option_D', 'answer_choice', 'code_test_one_input', 'code_test_two_input', 'code_test_three_input', 'code_test_one_output', 'code_test_two_output', 'code_test_three_output'], 'string'],
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
            'option_A' => Yii::t('app', 'Option A'),
            'option_B' => Yii::t('app', 'Option B'),
            'option_C' => Yii::t('app', 'Option C'),
            'option_D' => Yii::t('app', 'Option D'),
            'answer_choice' => Yii::t('app', 'Answer Choice'),
            'code_test_one_input' => Yii::t('app', 'Code Test Input'),
            'code_test_two_input' => Yii::t('app', 'Code Test Input'),
            'code_test_three_input' => Yii::t('app', 'Code Test Input'),
            'code_test_one_output' => Yii::t('app', 'Code Test Output'),
            'code_test_two_output' => Yii::t('app', 'Code Test Output'),
            'code_test_three_output' => Yii::t('app', 'Code Test Output'),
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

    public static function answerList()
    {
        return ['A', 'B', 'C', 'D'];
    }
}

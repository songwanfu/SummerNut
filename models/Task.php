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
    const INCLUDE_NOT_ALL = 1;//不包含"all"
    const INCLUDE_ALL = 2;//包含"all"

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

    public function attributes()
    {
        $attributesArr = array_keys(static::getTableSchema()->columns);
        return array_merge($attributesArr, ['option_A', 'option_B']);
        // $length = count($attributesArr);
        // $temp = [
        //     $length + 1 => 'country',
        //     $length + 2 => 'language',
        //      $length + 3 => 'lang_desc',
        // ];//添加自定义的属性
        // return (array_merge($attributesArr, ['country', 'language', 'lang_desc']));
        // return (array_merge($attributesArr, $temp));die;
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
            [['create_time', 'update_time'], 'default', 'value' => Common::getTime()],
        ];
    }

    public function validateAttr(Task $model)
    {
        if ($model->task_type == static::TYPE_CHOICE) {
            if (!$model['option_A']) {
                $model->addError('option_A', Yii::t('app', 'The option_A cannot be blank.'));
            }
            if (!$model['option_B']) {
                $model->addError('option_B', Yii::t('app', 'The option_B cannot be blank.'));
            }
            if (!$model['answer_choice']) {
                $model->addError('answer_choice', Yii::t('app', 'The answer_choice cannot be blank.'));
            }

            $optionArr = [
                'A' => $model['option_A'],
                'B' => $model['option_B'],
                'C' => $model['option_C'],
                'D' => $model['option_D'],
            ];
            $optionArr = array_filter($optionArr);
            $choiceArr = $model['answer_choice'];

            if (!$this->validateAnswer($optionArr, $choiceArr)) {
               $model->addError('answer_choice', Yii::t('app', 'The answer_choice is not correct.')); 
            }

            unset($model['answer_choice']);

            $model->option_json = json_encode($optionArr);
            $model->answer_json = json_encode($choiceArr);
            if ($model->is_timing == static::IS_NOT_TIMING) {
                $model->complete_time = '00:00';
            }
        }

        // if ($model->task_type == static::TYPE_SHORT_ANSWER || $model->task_type == static::TYPE_CALCULATION) {
        //     if (empty($model->answer_json)) {
        //         $model->addError('answer_json', Yii::t('app', 'The answer_json cannot be blank.'));
        //     }
        // }

        if ($model->task_type == static::TYPE_CODING) {
            if (empty($model['code_test_one_input'])) {
                $model->addError('code_test_one_input', Yii::t('app', 'code_test_one_input cannot be blank.'));
            }
            if (empty($model['code_test_one_output'])) {
                $model->addError('code_test_one_output', Yii::t('app', 'code_test_one_output cannot be blank.'));
            }
        }

        $model->update_time = Common::getTime();
        return $model;
    }

    public function validateAnswer($optionArr, $choiceArr)
    {
        $options = [];
        $choices = [];
        foreach ($optionArr as $k => $v) {
            $options[] = $k;
        }

        foreach ($choiceArr as $k => $v) {
            if (!in_array($v, $options)) {
                return false;
            }
        }
        return true;
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
            'code_test_one_input' => Yii::t('app', 'Code Test Input One'),
            'code_test_two_input' => Yii::t('app', 'Code Test Input Two'),
            'code_test_three_input' => Yii::t('app', 'Code Test Input Three'),
            'code_test_one_output' => Yii::t('app', 'Code Test Output One'),
            'code_test_two_output' => Yii::t('app', 'Code Test Output Two'),
            'code_test_three_output' => Yii::t('app', 'Code Test Output Three'),
        ];
    }

    public static function timingList($type = self::INCLUDE_NOT_ALL)
    {
        $temp = [];
        if ($type == self::INCLUDE_ALL) {
            $temp = ['' => Yii::t('app', 'All')];
        }
        $list = [
            static::IS_NOT_TIMING => Yii::t('app', 'Not Timing'),
            static::IS_TIMING => Yii::t('app', 'Timing'),
        ];
        return ($temp + $list);
    }

    public static function typeList($type = self::INCLUDE_NOT_ALL)
    {
        $temp = [];
        if ($type == self::INCLUDE_ALL) {
            $temp = ['' => Yii::t('app', 'All')];
        }
        $list = [
            static::TYPE_CHOICE => Yii::t('app', 'Task Choice'),
            static::TYPE_SHORT_ANSWER => Yii::t('app', 'Task Short Answer'),
            static::TYPE_CALCULATION => Yii::t('app', 'Task Calculation'),
            // static::TYPE_CODING => Yii::t('app', 'Task Coding'),
        ];
        return ($temp + $list);
    }

    public static function scoreList($type = self::INCLUDE_NOT_ALL)
    {
        $temp = [];
        if ($type == self::INCLUDE_ALL) {
            $temp = ['' => Yii::t('app', 'All')];
        }
        return $temp + [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
    }

    public static function timeList($type = self::INCLUDE_NOT_ALL)
    {
        $temp = [];
        if ($type == self::INCLUDE_ALL) {
            $temp = ['' => Yii::t('app', 'All')];
        }
        return $temp + ['00:00' => '00:00', '00:30' => '00:30', '01:00' => '01:00', '01:30' => '01:30', '02:00' => '02:00', '03:00' => '03:00', '05:00' => '05:00', '10:00' => '10:00', '15:00' => '15:00', '20:00' => '20:00', '30:00' => '30:00', '40:00' => '40:00', '50:00' => '50:00', '60:00' => '60:00'];
    }

    public static function answerList()
    {
        return ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'];
    }
}

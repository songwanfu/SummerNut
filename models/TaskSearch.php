<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_type', 'is_timing', 'score'], 'integer'],
            ['complete_time', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $course_id)
    {
        if (empty($course_id)) {
            $query = Task::find();
        } else {
            $query = Task::find()->where(['course_id' => $course_id]);
        }
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'course_id' => $this->course_id,
            'score' => $this->score,
            'task_type' => $this->task_type,
            'is_timing' => $this->is_timing,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'complete_time' => $this->complete_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'option_json', $this->option_json])
            ->andFilterWhere(['like', 'answer_json', $this->answer_json])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'complete_time', $this->complete_time]);

        return $dataProvider;
    }
}

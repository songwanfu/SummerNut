<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'type', 'status'], 'integer'],
            [['username', 'email', 'phone_number', 'faculty', 'signature', 'login_ip'], 'safe'],
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
    public function search($params)
    {
        $query = User::find();

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
            'sex' => $this->sex,
            'type' => $this->type,
            'status' => $this->status,
            'register_time' => $this->register_time,
            'login_time' => $this->login_time,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'head_picture', $this->head_picture])
            ->andFilterWhere(['like', 'accessToken', $this->accessToken])
            ->andFilterWhere(['like', 'authKey', $this->authKey])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'faculty', $this->faculty])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'login_ip', $this->login_ip]);

        return $dataProvider;
    }
}

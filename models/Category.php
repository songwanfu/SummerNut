<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property integer $direction
 * @property string $create_time
 */
class Category extends \yii\db\ActiveRecord
{
    const DIRECTION_FE = 1;//前端开发
    const DIRECTION_BE = 2;//后端开发
    const DIRECTION_MOBILE = 3;//移动开发
    const DIRECTION_DATA = 4;//数据处理
    const DIRECTION_PHOTO = 5;//图像处理

    public static $direction = ['fe', 'be', 'mobile', 'data', 'photo'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias', 'direction'], 'required'],
            [['direction'], 'integer'],
            [['create_time'], 'safe'],
            [['name', 'alias'], 'string', 'max' => 20],
            ['create_time', 'default', 'value' => Common::getTime()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
            'direction' => Yii::t('app', 'Direction'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    public static function directionList()
    {
        return [
            static::DIRECTION_FE => Yii::t('app', 'Front-End Develop'),
            static::DIRECTION_BE => Yii::t('app', 'Back-End Develop'),
            static::DIRECTION_MOBILE => Yii::t('app', 'Mobile Develop'),
            static::DIRECTION_DATA => Yii::t('app', 'Data Process'),
            static::DIRECTION_PHOTO => Yii::t('app', 'Photo Process'),
        ];
    }

    public static function directionAliasList()
    {
        return [
            'fe' => static::DIRECTION_FE,
            'be' => static::DIRECTION_BE,
            'mobile' => static::DIRECTION_MOBILE,
            'data' => static::DIRECTION_DATA,
            'photo' => static::DIRECTION_PHOTO,
        ];
    }

    public static function directionAliasFlipList()
    {
        return array_flip(static::directionAliasList());
    }


    public static function categoryMap($field = [])
    {
        $models = static::find($field)->orderBy('create_time DESC')->all();
        $list = [];
        $i = 0;
        foreach ($models as $model) {
            $list[$i][$field[0]] = $model->$field[0];
            $list[$i][$field[1]] = $model->$field[1];
            $i++;
        }
        return $list;
    }

    /**
     * [findModelsByDirection 通过方向查询分类对象]
     * @param  [integer] $directionId [方向ID]
     * @return [array]              [对象集合]
     */
    public static function findModelsByDirection($directionId)
    {
        return static::find()->where(['direction' => $directionId])->all();
    }

    public static function findModelByAlias($alias)
    {
        return static::find()->where(['alias' => $alias])->all();
    }

    public static function findAllModels()
    {
        return static::find()->all();
    }

    public static function aliasList()
    {
        $list = [];
        $models = static::findAllModels();
        foreach ($models as $model) {
            $list[] = $model->alias;
        }
        return $list;
    }

    public static function getDirectionByAlias($alias)
    {
        return static::findOne(['alias' => $alias]);
    }

    public static function findOneById($id)
    {
        return static::findOne(['id' => $id]);
    }

}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_banner".
 *
 * @property integer $id
 * @property string $title
 * @property string $img
 * @property string $jump_target
 * @property string $create_time
 * @property string $update_time
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 20],
            [['img', 'jump_target'], 'string', 'max' => 255],
            ['img', 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024*1024],
            [['create_time', 'update_time'], 'default', 'value' => Common::getTime()],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'img' => Yii::t('app', 'Img'),
            'jump_target' => Yii::t('app', 'Jump Target'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public static function bannerList()
    {
        return static::find()->orderBy('update_time DESC')->all();
    }
}

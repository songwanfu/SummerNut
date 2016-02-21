<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_resource_video".
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property string $url
 * @property string $size
 * @property string $duration
 * @property integer $status
 * @property integer $play_count
 * @property integer $download_count
 * @property string $create_time
 * @property string $update_time
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_resource_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size', 'status'], 'required'],
            [['status', 'play_count', 'download_count'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'icon', 'url'], 'string', 'max' => 255],
            [['size', 'duration'], 'string', 'max' => 10],
            // [['url'], 'file', 'extensions'=>'mp4'],
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
            'icon' => Yii::t('app', 'Icon'),
            'url' => Yii::t('app', 'Url'),
            'size' => Yii::t('app', 'Size'),
            'duration' => Yii::t('app', 'Duration'),
            'status' => Yii::t('app', 'Status'),
            'play_count' => Yii::t('app', 'Play Count'),
            'download_count' => Yii::t('app', 'Download Count'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
}

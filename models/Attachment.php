<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\Common;

/**
 * This is the model class for table "t_resource".
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property string $extension
 * @property string $url
 * @property string $size
 * @property string $duration
 * @property integer $status
 * @property integer $resource_type
 * @property integer $course_id
 * @property integer $play_count
 * @property integer $download_count
 * @property string $create_time
 * @property string $update_time
 */


class Attachment extends \yii\db\ActiveRecord
{
    public static $videoFormats = ['mp4', 'wmv', 'flv', 'avi', 'rmvb'];
    public static $imgFormats = ['jpg', 'jpeg', 'png'];
    public static $documentFormats = ['doc', 'ppt', 'xls', 'pdf', 'txt', 'html', 'zip'];

    const DEST_DIR = 'uploads';
    const VIDEO_DIR = 'video';
    const IMG_DIR = 'img';
    const DOCUMENT_DIR = 'document';

    const STATUS_NORAML = 1;
    const STATUS_AUTHEN = 2;
    const STATUS_TRANSCODE = 3;
    const STATUS_INVALID = 4;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_resource';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'size', 'status'], 'required'],
            [['status', 'resource_type', 'course_id', 'play_count', 'download_count'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'icon', 'url'], 'string', 'max' => 255],
            [['extension', 'size', 'duration'], 'string', 'max' => 10],
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
            'name' => Yii::t('app', 'Name'),
            'icon' => Yii::t('app', 'Icon'),
            'extension' => Yii::t('app', 'Extension'),
            'url' => Yii::t('app', 'Url'),
            'size' => Yii::t('app', 'Size'),
            'duration' => Yii::t('app', 'Duration'),
            'status' => Yii::t('app', 'Status'),
            'resource_type' => Yii::t('app', 'Resource Type'),
            'course_id' => Yii::t('app', 'Course ID'),
            'play_count' => Yii::t('app', 'Play Count'),
            'download_count' => Yii::t('app', 'Download Count'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }


    /**
     * [uploadFile Upload file.]
     * @param  [Object] $model    [active form model]
     * @param  [String] $attr     [attribute]
     * @param  string $rootPath [description]
     * @return [Object | null]           [description]
     */
    public static function uploadFile($model, $attr, $rootPath = '')
    {
        if ($rootPath == '') {
            $rootPath = Yii::$app->params['uploadUrl'];
        }

        $fileObj = UploadedFile::getInstance($model, $attr);
        // var_dump($fileObj->baseName);die;
        $model->name = $fileObj->baseName;
        $model->size = Common::transByte($fileObj->size);
        $model->extension = $fileObj->extension;
        if ($fileObj && $model->validate()) {
            $dir = self::getDir($fileObj->extension);
            $relaPath = '/' . $dir . '/' . $fileObj->baseName . '.'. time(). '.' . $fileObj->extension;
            $fileObj->saveAs($rootPath . $relaPath);
            $model->$attr = $relaPath;
            return $model;
        }
    }


    /**
     * [getDir Get file upload dir.]
     * @param  [String] $extension [The file extension]
     * @return [String]            [description]
     */
    public static function getDir($extension)
    {
        $dir = '';
        if (in_array($extension, self::$videoFormats)) {
            $dir = 'video';
        }
        if (in_array($extension, self::$imgFormats)) {
            $dir = 'img';
        }
        if (in_array($extension, self::$documentFormats)) {
            $dir = 'document';
        }
        return (self::DEST_DIR . '/' .$dir);
    }
}

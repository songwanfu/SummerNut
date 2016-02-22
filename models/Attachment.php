<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\Common;
/**
 * This is the model class for table "t_chapter_attachment".
 *
 * @property integer $id
 * @property integer $chapter_id
 * @property string $name
 * @property string $url
 * @property integer $download_count
 * @property string $upload_time
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_chapter_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chapter_id', 'url', 'download_count', 'size'], 'required'],
            [['chapter_id', 'download_count'], 'integer'],
            [['upload_time'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chapter_id' => Yii::t('app', 'Chapter ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'size' => Yii::t('app', 'size'),
            'download_count' => Yii::t('app', 'Download Count'),
            'upload_time' => Yii::t('app', 'Upload Time'),
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

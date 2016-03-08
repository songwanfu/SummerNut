<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
class Resource extends \yii\db\ActiveRecord
{
    public static $videoFormats = ['mp4', 'wmv', 'flv', 'avi', 'rmvb'];
    public static $imgFormats = ['jpg', 'jpeg', 'png'];
    public static $documentFormats = ['doc', 'ppt', 'xls', 'pdf', 'txt', 'html', 'zip'];

    const DEST_DIR = 'uploads';
    const VIDEO_DIR = 'video';
    const IMG_DIR = 'img';
    const DOCUMENT_DIR = 'document';

    const STATUS_NORAML = 1;//正常
    const STATUS_AUTHEN = 2;//审核中
    const STATUS_TRANSCODE = 3;//转码中
    const STATUS_INVALID = 4;//不可用

    const TYPE_VIDEO = 1;//视频
    const TYPE_ATTACHMENT = 2;//附件

    const INCLUDE_NOT_ALL = 1;
    const INCLUDE_ALL = 2;

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
            ['url', 'file', 'extensions' => array_merge(self::$videoFormats, self::$imgFormats, self::$documentFormats)],
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

    public static function statusList($type = self::INCLUDE_NOT_ALL)
    {
        $temp = [];
        if ($type == self::INCLUDE_ALL) {
            $temp = ['' => Yii::t('app', 'All')];
        }
        $list =  [
            self::STATUS_NORAML => Yii::t('app', 'Video Normal'),
            self::STATUS_AUTHEN => Yii::t('app', 'Video Authen'),
            self::STATUS_TRANSCODE => Yii::t('app', 'Video Transcode'),
            self::STATUS_INVALID => Yii::t('app', 'Video Invalid'),
        ];
        return ($temp + $list);
    }

    public static function typeList($type = self::INCLUDE_NOT_ALL)
    {
        $temp = [];
        if ($type == self::INCLUDE_ALL) {
            $temp = ['' => Yii::t('app', 'All')];
        }

        $list =  [
            self::TYPE_VIDEO => Yii::t('app', 'Video'),
            self::TYPE_ATTACHMENT => Yii::t('app', 'Attachment'),
        ];
        return ($temp + $list);
    }

    /**
     * [uploadFile Upload file.]
     * @param  [Object] $model    [active form model]
     * @param  [String] $attr     [attribute]
     * @param  string $rootPath [description]
     * @return [Object | null]           [description]
     */
    public function uploadFile(Resource $model, $attr, $rootPath = '')
    {
        $fileObj = UploadedFile::getInstance($model, $attr);
        
        $model->name = $fileObj->baseName;
        $model->size = Common::transByte($fileObj->size);
        $model->extension = $fileObj->extension;
        $model->status = $this->setStatus($fileObj->extension);
        $model->resource_type = $this->setResType($fileObj->extension, $model->course_id);

        return $this->upload($model, $attr, $rootPath);
        // var_dump($model);die;
        // $dir = $this->setDir($fileObj->extension);
        // $relaPath = '/' . $dir . '/' . $fileObj->baseName . '.'. time(). '.' . $fileObj->extension;
        // $model->$attr = $relaPath;

        // if ($fileObj && $model->validate()) {
        //     $fileObj->saveAs($rootPath . $relaPath);
        //     return $model;
        // }
    }

    public function uploadImg($model, $attr, $rootPath = '')
    {
        return $this->upload($model, $attr, $rootPath);
    }

    public function upload($model, $attr, $rootPath = '')
    {
        if ($rootPath == '') {
            $rootPath = Yii::$app->params['uploadUrl'];
        }
        
        $fileObj = UploadedFile::getInstance($model, $attr);

        if (!$fileObj) {
            return $model;
        }

        $dir = $this->setDir($fileObj->extension);
        $relaPath = '/' . $dir . '/' . $fileObj->baseName . '.'. time(). '.' . $fileObj->extension;
        $model->$attr = $relaPath;
        if ($fileObj && $model->validate()) {
            $fileObj->saveAs($rootPath . $relaPath);
            return $model;
        }
    }

    /**
     * [setDir Set file upload dir.]
     * @param  [String] $extension [The file extension]
     * @return [String]            [description]
     */
    public function setDir($extension)
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

    /**
     * [setStatus Set resource status.]
     * @param [type] $extension [file extension]
     */
    public function setStatus($extension)
    {
        if (in_array($extension, self::$videoFormats) && $extension != 'mp4') {
            return self::STATUS_TRANSCODE;
        }
        return self::STATUS_AUTHEN;
    }

    /**
     * [setResType Set resource type.]
     * @param  [type] $extension [file extension]
     * @param  [type] $course_id [course id]
     * @return [type]            [description]
     */
    public function setResType($extension, $course_id)
    {
        if (in_array($extension, self::$videoFormats) && empty($this->getVideo($course_id))) {
            return self::TYPE_VIDEO;
        }
        return self::TYPE_ATTACHMENT;
    }

    /**
     * [getModels Get all models]
     * @param  Array  $condition [description]
     * @return [type]            [description]
     */
    public function getModels($fieldArr = [], $condition = [], $sort = [])
    {
        return self::find()->select($fieldArr)->where($condition)->orderBy($sort)->all();
    }

    /**
     * [getVideo Get main video]
     * @param  [type] $course_id [course id]
     * @return [type]            [description]
     */
    public function getVideo($course_id)
    {
        return self::findOne(['course_id' => $course_id, 'resource_type' => self::TYPE_VIDEO]);
    }

    public function getAttachments($course_id)
    {
        return self::find()->where(['course_id' => $course_id, 'resource_type' => self::TYPE_ATTACHMENT])->orderBy('create_time')->all();
    }

    
    /**
     * [transcode Transcode video]
     * @param  [Resource] $model []
     * @return [bool]        [success or failed]
     */
    public function transcode(Resource $model)
    {
        if ($model->save()) {
            $rootPath = Yii::$app->params['uploadUrl'];
            $time = time();
            exec("ffmpeg -i $rootPath$model->url -f mp4 -vcodec libx264 -s 640x360 $rootPath/uploads/video/$model->name.$time.mp4", $res, $rc);
            if (!$rc) {
                $model->status = static::STATUS_AUTHEN;
                $model->extension = 'mp4';
                $model->url = "/uploads/video/$model->name.$time.mp4";
                $model->update_time = Common::getTime();
                if ($model->save()) {
                    return true;
                }
            }
            
        }

        return false;
    }

    public function getTranscodeVideos()
    {
        return $this->getModels([], ['status' => static::STATUS_TRANSCODE, 'resource_type' => static::TYPE_VIDEO]);
    }

    public function findOneTranscodeVideo()
    {
        return self::findOne(['status' => static::STATUS_TRANSCODE, 'resource_type' => static::TYPE_VIDEO]);
    }

    public function getAuthenVideos()
    {
        return $this->getModels(['url'], ['status' => static::STATUS_AUTHEN, 'resource_type' => static::TYPE_VIDEO]);
    }


}

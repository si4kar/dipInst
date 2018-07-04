<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class Storage extends Component implements StorageInterface
{

    private $fileName;

    /**
     * Save given UploadedFile instance to disc
     * @param UploadedFile $file
     * @return string|null
     */

    public function saveUploadedFile(UploadedFile $file)
    {
        $path = $this->preparePath($file);

        if ($path && $file->saveAs($path)) {
            return $this->fileName;
        }
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function deleteFile(string $filename)
    {
        $file = $this->getStoragePath().$filename;

        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }


    /**
     * Prepare path to save uploaded file
     * @param UploadedFile $file
     * @return string|null
     */
    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);

        $path = $this->getStoragePath() . $this->fileName;

        $path = FileHelper::normalizePath($path);
        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */

    protected function getFileName(UploadedFile $file)
    {
        // $file->tempname - /tmp/qio93kf

        $hash = sha1_file($file->tempName);

        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);

        return $name . '.' . $file->extension;
    }

    /**
     * @return string
     */
    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'].$filename;
    }




}
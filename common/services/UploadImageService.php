<?php
declare(strict_types=1);

namespace common\services;

use common\helpers\ImageHelper;
use common\interfaces\ExecuteInterface;
use common\models\db\Image;
use RuntimeException;
use Yii;
use yii\web\UploadedFile;

/**
 * Class UploadImageService
 * @package common\services
 */
class UploadImageService implements ExecuteInterface
{
    /**
     * @var \yii\web\UploadedFile $_file
     */
    private UploadedFile $_file;

    /**
     * @var \common\models\db\Image|null
     */
    private ?Image $_image = null;

    /**
     * @param \yii\web\UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->_file = $file;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        $file_name = substr(md5(uniqid('', true)), -20) . '.' . $this->_file->extension;

        $path = ImageHelper::generatePath();

        $upload_dir = Yii::getAlias('@frontend') . '/web/upload/' . implode('/', $path);
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true) && !is_dir($upload_dir)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $upload_dir));
            }
        }

        $upload_url = $upload_dir . '/' . $file_name;
        $file_url = '/upload/' . implode('/', $path) . '/' . $file_name;
        if ($this->_file->saveAs($upload_dir . '/' . $file_name)) {
            chmod($upload_url, 0777);
        }

        $this->_image = new Image();
        $this->_image->path = $file_url;
        return $this->_image->save();
    }

    /**
     * @return int
     */
    public function getImageId(): int
    {
        return $this->_image->id ?? 0;
    }
}
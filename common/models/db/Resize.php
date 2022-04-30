<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Resize
 * @package common\models\db
 *
 * @property int $id
 * @property int $created_at
 * @property int $height
 * @property int $image_id
 * @property string $path
 * @property int $updated_at
 * @property int $width
 *
 * @property Image $image
 */
class Resize extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%resize}}';
    }

    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['cut', 'height', 'image_id', 'path', 'width'], 'required'],
            [['path'], 'string', 'max' => 255],
            [['cut', 'height', 'image_id', 'width'], 'integer'],
            [['image_id'], 'exist', 'targetRelation' => 'image'],
        ];
    }

    /**
     * @return bool
     */
    public function beforeDelete(): bool
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/frontend/web' . $this->path)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/frontend/web' . $this->path);
        }
        return parent::beforeDelete();
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created at'),
            'height' => Yii::t('app', 'Height'),
            'image_id' => Yii::t('app', 'Image'),
            'path' => Yii::t('app', 'Path'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'width' => Yii::t('app', 'Width'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage(): ActiveQuery
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}

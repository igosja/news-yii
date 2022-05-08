<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Image
 * @package common\models\db
 *
 * @property int $id
 * @property int $created_at
 * @property string $path
 * @property int $updated_at
 *
 * @property Resize[] $resizes
 */
class Image extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%image}}';
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
            [['path'], 'required'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete(): bool
    {
        foreach ($this->resizes as $resize) {
            $resize->delete();
        }
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
            'path' => Yii::t('app', 'Path'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResizes(): ActiveQuery
    {
        return $this->hasMany(Resize::class, ['image_id' => 'id']);
    }
}

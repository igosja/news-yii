<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package common\models\db
 *
 * @property int $id
 * @property int $created_at
 * @property bool $is_active
 * @property string $name
 * @property array $translation
 * @property int $updated_at
 */
class Category extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%category}}';
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
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['name', 'translation'], 'required'],
            [['name'], 'trim'],
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => false],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created at'),
            'is_active' => Yii::t('app', 'Is active'),
            'name' => Yii::t('app', 'Name'),
            'translation' => Yii::t('app', 'Translation'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id',
            'created_at',
            'is_active',
            'title' => function () {
                return $this->translation[Yii::$app->language];
            },
            'updated_at',
        ];
    }
}

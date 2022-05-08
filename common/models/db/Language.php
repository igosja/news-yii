<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Language
 * @package common\models\db
 *
 * @property int $id
 * @property string $code
 * @property int $created_at
 * @property bool $is_active
 * @property string $name
 * @property int $updated_at
 */
class Language extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%language}}';
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
            [['code', 'name'], 'required'],
            [['code', 'name'], 'trim'],
            [['code'], 'string', 'length' => 2],
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
            'code' => Yii::t('app', 'Code'),
            'created_at' => Yii::t('app', 'Created at'),
            'is_active' => Yii::t('app', 'Is active'),
            'name' => Yii::t('app', 'Name'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return array
     */
    public static function codes(): array
    {
        return self::find()->select(['code'])->column();
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'code',
            'name',
        ];
    }
}

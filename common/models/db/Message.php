<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Message
 * @package common\models\db
 *
 * @property int $id
 * @property string $language
 * @property string $translation
 */
class Message extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%message}}';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['language', 'translation'], 'required'],
            [['language'], 'string', 'max' => 16],
            [['translation'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'language' => Yii::t('app', 'Language'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }
}

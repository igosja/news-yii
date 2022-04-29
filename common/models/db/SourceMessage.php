<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class SourceMessage
 * @package common\models\db
 *
 * @property int $id
 * @property string $category
 * @property string $message
 * @property-read \common\models\db\Message[] $messages
 */
class SourceMessage extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%source_message}}';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['category', 'message'], 'required'],
            [['category'], 'string', 'max' => 255],
            [['message'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
        ];
    }

    /**
     * @param string $languageCode
     * @return \yii\db\ActiveQuery
     */
    public function getMessage(string $languageCode): ActiveQuery
    {
        return $this->hasOne(Message::class, ['id' => 'id'])->andWhere(['language' => $languageCode]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(Message::class, ['id' => 'id']);
    }
}

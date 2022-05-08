<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Comment
 * @package common\models\db
 *
 * @property int $id
 * @property int $created_at
 * @property int $created_by
 * @property int $language_id
 * @property int $post_id
 * @property string $text
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Post $post
 * @property User $createdBy
 * @property Language $language
 * @property User $updatedBy
 */
class Comment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%comment}}';
    }

    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['language_id', 'post_id', 'text'], 'required'],
            [['text'], 'trim'],
            [['created_at', 'created_by', 'language_id', 'post_id', 'updated_at', 'updated_by'], 'integer'],
            [['language_id'], 'exist', 'targetRelation' => 'language'],
            [['post_id'], 'exist', 'targetRelation' => 'post'],
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
            'created_by' => Yii::t('app', 'Created by'),
            'language_id' => Yii::t('app', 'Language'),
            'post_id' => Yii::t('app', 'Post'),
            'text' => Yii::t('app', 'Text'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'updated_by' => Yii::t('app', 'Updated by'),
        ];
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'created_at',
            'createdBy',
            'language',
            'post_id',
            'text',
            'updated_at',
            'updatedBy',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage(): ActiveQuery
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost(): ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}

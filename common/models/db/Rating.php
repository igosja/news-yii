<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Rating
 * @package common\models\db
 *
 * @property int $id
 * @property int $created_at
 * @property int $created_by
 * @property int $post_id
 * @property int $updated_at
 * @property int $updated_by
 * @property int $value
 *
 * @property Post $post
 * @property User $createdBy
 * @property User $updatedBy
 */
class Rating extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%rating}}';
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
            [['post_id', 'value'], 'required'],
            [['created_at', 'created_by', 'post_id', 'updated_at', 'updated_by', 'value'], 'integer'],
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
            'post_id' => Yii::t('app', 'Post'),
            'text' => Yii::t('app', 'Text'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'updated_by' => Yii::t('app', 'Updated by'),
            'value' => Yii::t('app', 'Value'),
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

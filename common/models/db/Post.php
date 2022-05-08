<?php
declare(strict_types=1);

namespace common\models\db;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Post
 * @package common\models\db
 *
 * @property int $id
 * @property int $category_id
 * @property int $created_at
 * @property int $created_by
 * @property int $image_id
 * @property bool $is_active
 * @property string $name
 * @property array $translation_text
 * @property array $translation_title
 * @property int $updated_at
 * @property int $updated_by
 * @property int $url
 * @property int $views
 *
 * @property Category $category
 * @property User $createdBy
 * @property Image $image
 * @property User $updatedBy
 */
class Post extends ActiveRecord
{
    /**
     * @var string $upload_image
     */
    public string $upload_image = '';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%post}}';
    }

    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => ['id', 'name'],
                'ensureUnique' => true,
                'slugAttribute' => 'url',
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['category_id', 'name', 'translation_text', 'translation_title'], 'required'],
            [['name', 'url'], 'trim'],
            [['url'], 'unique'],
            [['is_active'], 'boolean'],
            [['category_id', 'created_at', 'created_by', 'image_id', 'updated_at', 'updated_by', 'views'], 'integer'],
            [['category_id'], 'exist', 'targetRelation' => 'category'],
            [['image_id'], 'exist', 'targetRelation' => 'image'],
            [['upload_image'], 'image', 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete(): bool
    {
        $this->image?->delete();
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
            'created_by' => Yii::t('app', 'Created by'),
            'image_id' => Yii::t('app', 'Image'),
            'is_active' => Yii::t('app', 'Is active'),
            'name' => Yii::t('app', 'Name'),
            'translation_text' => Yii::t('app', 'Translation text'),
            'translation_title' => Yii::t('app', 'Translation title'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'updated_by' => Yii::t('app', 'Updated by'),
            'url' => Yii::t('app', 'Url'),
            'views' => Yii::t('app', 'Views'),
        ];
    }

    /**
     * @return int
     */
    public function rating(): int
    {
        return (int)Rating::find()->andWhere(['post_id' => $this->id])->sum('value');
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id',
            'category' => function () {
                return $this->category;
            },
            'created_at',
            'createdBy' => function () {
                return $this->createdBy;
            },
            'image' => function () {
                return $this->image;
            },
            'is_active',
            'rating' => function () {
                return $this->rating();
            },
            'text' => function () {
                return $this->translation_text[Yii::$app->language];
            },
            'title' => function () {
                return $this->translation_title[Yii::$app->language];
            },
            'updated_at',
            'updatedBy' => function () {
                return $this->updatedBy;
            },
            'url',
            'views',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
    public function getImage(): ActiveQuery
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}

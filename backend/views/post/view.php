<?php
declare(strict_types=1);

use common\helpers\ErrorHelper;
use common\models\db\Language;
use common\models\db\Post;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var \common\models\db\Post $model
 * @var \yii\web\View $this
 */

?>
<ul class="list-inline text-center">
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => ['btn', 'btn-default']]) ?>
    </li>
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => ['btn', 'btn-default']]) ?>
    </li>
    <li class="list-inline-item">
        <?= Html::a(
            Yii::t('app', 'Delete'),
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-default',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure?'),
                ],
            ]
        ) ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'id',
            'name',
            'url',
            'category.name',
            [
                'attribute' => 'image_id',
                'format' => 'raw',
                'value' => static function (Post $model) {
                    if ($model->image) {
                        return Html::img($model->image->path, ['class' => 'img-fluid']);
                    }
                    return '';
                }
            ],
        ];
        foreach (Language::codes() as $code) {
            $attributes[] = [
                'label' => $model->getAttributeLabel('translation_title') . ' (' . $code . ')',
                'value' => $model->translation_title[$code],
            ];
        }
        foreach (Language::codes() as $code) {
            $attributes[] = [
                'label' => $model->getAttributeLabel('translation_text') . ' (' . $code . ')',
                'value' => $model->translation_text[$code],
            ];
        }
        $attributes = ArrayHelper::merge($attributes, [
            'is_active:boolean',
            'created_at:datetime',
            'createdBy.username',
            'updated_at:datetime',
            'updatedBy.username',
        ]);
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Throwable $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
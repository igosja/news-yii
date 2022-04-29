<?php
declare(strict_types=1);

use common\helpers\ErrorHelper;
use common\models\db\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var \common\models\db\Category $model
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
        ];
        foreach (Language::codes() as $code) {
            $attributes[] = [
                'label' => $model->getAttributeLabel('translation') . ' (' . $code . ')',
                'value' => $model->translation[$code],
            ];
        }
        $attributes = ArrayHelper::merge($attributes, [
            'is_active:boolean',
            'created_at:datetime',
            'updated_at:datetime',
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
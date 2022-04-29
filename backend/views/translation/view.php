<?php
declare(strict_types=1);

use common\helpers\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var \common\models\db\Language[] $languageArray
 * @var \common\models\db\SourceMessage $model
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
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'id',
            'category',
            'message',
        ];
        foreach ($languageArray as $language) {
            $attributes[] = [
                'label' => $language->name,
                'value' => $model->getMessage($language->code)->one()?->translation,
            ];
        }
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Throwable $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>

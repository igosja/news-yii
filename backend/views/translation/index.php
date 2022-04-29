<?php
declare(strict_types=1);

use common\helpers\ErrorHelper;
use common\models\db\SourceMessage;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\db\Language[] $languageArray
 * @var \backend\models\search\SourceMessageSearch $searchModel
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'id',
                'headerOptions' => ['class' => 'col-lg-1'],
            ],
            'category',
            'message',
        ];

        foreach ($languageArray as $language) {
            $columns[] = [
                'label' => $language->name,
                'value' => static function (SourceMessage $model) use ($language): ?string {
                    foreach ($model->messages as $message) {
                        if ($message->language === $language->code) {
                            return $message->translation;
                        }
                    }
                    return null;
                },
            ];
        }

        $columns[] = [
            'class' => ActionColumn::class,
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'col-lg-1'],
            'template' => '{view} {update}',
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
        ]);
    } catch (Throwable $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>

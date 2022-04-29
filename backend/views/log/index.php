<?php
declare(strict_types=1);

/**
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \backend\models\search\LogSearch $searchModel
 */

use common\helpers\ErrorHelper;
use common\models\db\Log;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<ul class="list-inline text-center">
    <li class="list-inline-item">
        <?= Html::a(
            Yii::t('app', 'Clear'),
            ['clear'],
            [
                'class' => ['btn', 'btn-default'],
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure?'),
                ],
            ]
        ) ?>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <?php

        try {
            $columns = [
                [
                    'attribute' => 'log_time',
                    'format' => 'datetime',
                    'headerOptions' => ['class' => 'col-lg-1'],
                ],
                [
                    'attribute' => 'message',
                    'format' => 'raw',
                    'value' => static function (Log $model) {
                        return nl2br($model->message);
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'col-lg-1'],
                    'template' => '{delete}',
                ],
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
</div>

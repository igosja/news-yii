<?php
declare(strict_types=1);

use common\helpers\ErrorHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\search\LanguageSearch $searchModel
 * @var \yii\web\View $this
 */

?>
<h1><?= Html::encode($this->title) ?></h1>
<ul class="list-inline text-center">
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => ['btn', 'btn-default']]) ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'id',
                'headerOptions' => ['class' => 'col-lg-1'],
            ],
            'name',
            'code',
            [
                'attribute' => 'is_active',
                'format' => 'boolean',
                'headerOptions' => ['class' => 'col-lg-3'],
            ],
            [
                'class' => ActionColumn::class,
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-lg-1'],
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
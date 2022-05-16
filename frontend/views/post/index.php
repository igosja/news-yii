<?php

/**
 * @var \common\models\db\Category[] $categories
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var yii\web\View $this
 */

use common\helpers\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ListView;

?>
<div class="site-index">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <ul class="list-inline text-center">
        <?php foreach ($categories as $category): ?>
            <li class="list-inline-item">
                <?= Html::a($category->translation[Yii::$app->language], ['index', 'category_id' => $category->id], ['class' => ['btn', 'btn-default']]) ?>
            </li>
        <?php endforeach ?>
    </ul>
    <?php
    try {
        print ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '//post/_post',
            'summary' => false,
        ]);
    } catch (Throwable $e) {
        ErrorHelper::log($e);
    }
    ?>
</div>

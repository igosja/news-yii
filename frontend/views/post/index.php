<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var yii\web\View $this
 */

use common\helpers\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ListView;

?>
<div class="site-index">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
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

<?php

/**
 * @var \common\models\db\Post $model
 */

use yii\helpers\Html;

?>
<h1 class="text-center"><?= $model->translation_title[Yii::$app->language] ?></h1>
<div class="col-12">
    <?= Html::img($model->image->path, ['class' => 'img-fluid']) ?>
    <?= $model->translation_text[Yii::$app->language] ?>
</div>

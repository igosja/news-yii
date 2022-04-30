<?php

/**
 * @var \common\models\db\Post $model
 */

use yii\helpers\Html;

?>
<div class="col-4">
    <?= Html::img($model->image->path, ['class' => 'img-thumbnail']) ?>
    <?= $model->translation_title[Yii::$app->language] ?>
    <?= Html::a(Yii::t('app', 'Read'), ['/post/view', 'url' => $model->url]) ?>
</div>

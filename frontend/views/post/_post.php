<?php

/**
 * @var \common\models\db\Post $model
 */

use common\helpers\ErrorHelper;
use common\helpers\ImageHelper;
use yii\helpers\Html;

?>
<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 rounded">
    <div class="row">
        <div class="col-12">
            <?= Html::img(ImageHelper::resize($model->image_id, 569, 320), ['class' => 'img-fluid']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 small text-muted">
            <?php
            try {
                print Yii::$app->formatter->asDatetime($model->created_at, 'short');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }
            ?>
            (<strong><?= $model->createdBy->username ?></strong>)
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-truncate">
            <?= $model->translation_title[Yii::$app->language] ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= Html::a(
                Yii::t('app', 'Read'),
                ['/post/view', 'url' => $model->url],
                ['class' => ['btn', 'btn-outline-secondary']]
            ) ?>
        </div>
    </div>
</div>

<?php

/**
 * @var \common\models\db\Comment $model
 */

use common\helpers\ErrorHelper;
use yii\helpers\Html;

?>
<div class="col-row mt-2">
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
    <div class="col-12">
        <?= Html::encode($model->text) ?>
    </div>
</div>

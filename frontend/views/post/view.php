<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\db\Comment $model
 * @var \common\models\db\Post $post
 */

use common\helpers\ErrorHelper;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

?>
<h1 class="text-center"><?= $post->translation_title[Yii::$app->language] ?></h1>
<div class="col-12">
    <?= Html::img($post->image->path, ['class' => 'img-fluid']) ?>
    <?= $post->translation_text[Yii::$app->language] ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'text')->textInput() ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
<?php
try {
    print ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '//post/_comment',
        'summary' => false,
    ]);
} catch (Throwable $e) {
    ErrorHelper::log($e);
}
?>

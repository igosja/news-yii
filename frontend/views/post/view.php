<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\db\Comment $model
 * @var \common\models\db\Post $post
 */

use common\helpers\ErrorHelper;
use common\helpers\ImageHelper;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

?>
<h1 class="text-center"><?= $post->translation_title[Yii::$app->language] ?></h1>
<div class="row small">
    <div class="col-9 text-muted">
        <?php
        try {
            print Yii::$app->formatter->asDatetime($post->created_at, 'medium');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
        ?>
        (<strong><?= $post->createdBy->username ?></strong>)
    </div>
    <div class="col-3 text-end">
        <?= Html::a('+', ['post/rating', 'url' => $post->url, 'value' => 1], ['class' => 'link-success']) ?>
        <?= $post->rating() ?>
        <?= Html::a('-', ['post/rating', 'url' => $post->url, 'value' => -1], ['class' => 'link-danger']) ?>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?= Html::img(
            ImageHelper::resize($post->image_id, 1140, 641),
            ['alt' => $post->translation_title[Yii::$app->language], 'class' => 'img-fluid']
        ) ?>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?= $post->translation_text[Yii::$app->language] ?>
    </div>
</div>
<hr/>
<div class="row small">
    <div class="col-12 text-center mb-2">
        <?= Yii::t('app', 'Comments') ?>:
    </div>
</div>
<div class="row small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin() ?>
        <?= $form
            ->field($model, 'text')
            ->textInput([
                'class' => ['form-control', 'form-control-sm'],
                'placeholder' => $model->getAttributeLabel('text'),
            ])
            ->label(false) ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => ['btn', 'btn-outline-dark', 'btn-sm']]) ?>
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
        'options' => ['class' => 'small'],
    ]);
} catch (Throwable $e) {
    ErrorHelper::log($e);
}
?>

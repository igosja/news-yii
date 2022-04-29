<?php
declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var \common\models\db\Language[] $languageArray
 * @var \common\models\db\SourceMessage $model
 * @var \common\models\db\Message[] $models
 * @var \yii\web\View $this
 */

?>
<ul class="list-inline text-center">
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => ['btn', 'btn-default']]) ?>
    </li>
    <li class="list-inline-item">
        <?= Html::a(Yii::t('app', 'View'), ['view', 'id' => $model->id], ['class' => ['btn', 'btn-default']]) ?>
    </li>
</ul>
<?= $this->render('_form', ['languageArray' => $languageArray, 'model' => $model, 'models' => $models]) ?>

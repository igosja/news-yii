<?php
declare(strict_types=1);

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use backend\assets\AppAsset;
use common\helpers\ErrorHelper;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => ['navbar', 'navbar-expand-md', 'navbar-dark', 'bg-dark', 'fixed-top'],
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('app', 'Translations'), 'url' => ['/translation/index']],
        ['label' => Yii::t('app', 'Languages'), 'url' => ['/language/index']],
        ['label' => Yii::t('app', 'Logs'), 'url' => ['/log/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Log In'), 'url' => ['/site/login']];
    }

    try {
        print Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    if (Yii::$app->user->isGuest) {
        echo Html::tag(
            'div',
            Html::a(
                Yii::t('app', 'Log In'),
                ['/site/login'],
                ['class' => ['btn', 'btn-link', 'login', 'text-decoration-none']]
            ),
            ['class' => ['d-flex']]
        );
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                ['class' => ['btn', 'btn-link', 'logout', 'text-decoration-none']]
            )
            . Html::endForm();
    }
    NavBar::end()
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?php
        try {
            print Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'] ?? [],
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        } ?>
        <?php
        try {
            print Alert::widget();
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        } ?>
        <?= $this->title ? '<h1 class="text-center">' . $this->title . '</h1>' : '' ?>
        <?= $content ?>
    </div>
</main>
<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

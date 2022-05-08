<?php
declare(strict_types=1);

namespace api\controllers;

use yii\web\ErrorAction;

/**
 * Class SiteController
 * @package api\controllers
 */
class SiteController extends AbstractController
{
    /**
     * @return \string[][]
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}

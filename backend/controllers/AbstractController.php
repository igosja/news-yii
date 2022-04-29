<?php
declare(strict_types=1);

namespace backend\controllers;

use common\components\AbstractWebController;
use yii\filters\AccessControl;

/**
 * Class AbstractController
 * @package backend\controllers
 */
abstract class AbstractController extends AbstractWebController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
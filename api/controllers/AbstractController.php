<?php
declare(strict_types=1);

namespace api\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Class AbstractController
 * @package api\controllers
 */
abstract class AbstractController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
<?php
declare(strict_types=1);

namespace common\helpers;

use Throwable;
use Yii;

/**
 * Class ErrorHelper
 * @package common\helpers
 */
class ErrorHelper
{
    /**
     * @param \Throwable $e
     * @return void
     */
    public static function log(Throwable $e): void
    {
        Yii::error($e->__toString());
    }
}

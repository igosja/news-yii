<?php
declare(strict_types=1);

namespace common\services;

use common\interfaces\ExecuteInterface;
use common\models\forms\LoginForm;
use Yii;

/**
 * Class LoginService
 * @package common\services
 */
class LoginService implements ExecuteInterface
{
    /**
     * @var \common\models\forms\LoginForm $_form
     */
    protected LoginForm $_form;

    /**
     * @param \common\models\forms\LoginForm $form
     */
    public function __construct(LoginForm $form)
    {
        $this->_form = $form;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        if (!$this->_form->validate()) {
            return false;
        }

        return Yii::$app->user->login($this->_form->getUser(), $this->_form->rememberMe ? 3600 * 24 * 30 : 0);
    }
}
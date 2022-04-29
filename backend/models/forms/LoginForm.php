<?php
declare(strict_types=1);

namespace backend\models\forms;

use common\models\db\User;

/**
 * Class LoginForm
 * @package common\models
 *
 * @property-read null|\common\models\db\User $user
 */
class LoginForm extends \common\models\forms\LoginForm
{
    /**
     * @return \common\models\db\User|null
     */
    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::find()
                ->andWhere([
                    'status' => User::STATUS_ACTIVE,
                    'username' => $this->username,
                    'user_role' => User::ROLE_ADMIN,
                ])->one();
        }

        return $this->_user;
    }
}

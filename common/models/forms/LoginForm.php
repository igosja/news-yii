<?php
declare(strict_types=1);

namespace common\models\forms;

use common\models\db\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package common\models\form
 *
 * @property-read null|\common\models\db\User $user
 */
class LoginForm extends Model
{
    /**
     * @var string $username
     */
    public string $username = '';

    /**
     * @var string $password
     */
    public string $password = '';

    /**
     * @var bool $rememberMe
     */
    public bool $rememberMe = true;

    /**
     * @var \common\models\db\User|null $_user
     */
    protected ?User $_user = null;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            [['rememberMe'], 'boolean'],
            [['password'], 'validatePassword'],
        ];
    }

    /**
     * @param string $attribute
     * @return void
     */
    public function validatePassword(string $attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return \common\models\db\User|null
     */
    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember me'),
            'username' => Yii::t('app', 'Username'),
        ];
    }
}

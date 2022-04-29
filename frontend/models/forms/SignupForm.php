<?php
declare(strict_types=1);

namespace frontend\models\forms;

use common\models\db\User;
use Yii;
use yii\base\Model;

/**
 * Class SignupForm
 * @package frontend\models\forms
 */
class SignupForm extends Model
{
    /**
     * @var string $email
     */
    public string $email = '';

    /**
     * @var string $password
     */
    public string $password = '';

    /**
     * @var string $username
     */
    public string $username = '';

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email'], 'email'],
            [['username', 'email'], 'trim'],
            [['username', 'email', 'password'], 'required'],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            [['username', 'email'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * @return bool|null
     * @throws \yii\base\Exception
     */
    public function signup(): ?bool
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * @param \common\models\db\User $user
     * @return bool
     */
    protected function sendEmail(User $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
        ];
    }
}

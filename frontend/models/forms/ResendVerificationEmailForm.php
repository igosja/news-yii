<?php
declare(strict_types=1);

namespace frontend\models\forms;

use common\models\db\User;
use Yii;
use yii\base\Model;

/**
 * Class ResendVerificationEmailForm
 * @package frontend\models\forms
 */
class ResendVerificationEmailForm extends Model
{
    /**
     * @var string $email
     */
    public string $email = '';

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email'], 'trim'],
            [['email'], 'required'],
            [['email'], 'email'],
            [
                ['email'],
                'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => Yii::t('app', 'There is no user with this email address.')
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('app', 'Email')
        ];
    }
}

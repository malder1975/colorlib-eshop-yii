<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.01.2019
 * Time: 23:44
 */

namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResetPasswordForm;
use http\Exception\RuntimeException;

class PasswordResetService
{
    public function request(PasswordResetRequestForm $form): void
    {
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException('Пользователь не найден!');
        }

        $user->requestPasswordReset();

        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохраниения!');
        }

        $sent = \Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . 'robot'])
            ->setTo($user->email)
            ->setSubject('Восстановление пароля для' . \Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new RuntimeException('Ошибка отправки письма!');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Ключ восстановления пароля не может быть пустым');
        }
        if (!User::findByPasswordResetToken($token)) {
            throw new \DomainException('Неверный ключ восстановления пароля.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = User::findByPasswordResetToken($token);

        if (!$user) {
            throw new \DomainException('Пользователь не найден!');
        }

        $user->resetPassword($form->password);

        if (!$user ->save()) {
            throw new RuntimeException('Ошибка сохранения.');
        }
    }
}
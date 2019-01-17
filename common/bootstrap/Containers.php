<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.01.2019
 * Time: 22:16
 */

namespace common\bootstrap;

use frontend\services\auth\PasswordResetService;
use frontend\services\auth\SignupService;
use frontend\services\ContactService;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;


class Containers implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->SetSingleton(MailerInterface::class, function() use ($app) {
            return $app->mailer;
        });

        $container->SetSingleton(PasswordResetService::class, [], [
            //[$app->params['supportEmail'] => $app->name . 'robot'],
            //Instance::of(MailerInterface::class),
        ]);

        $container->SetSingleton(ContactService::class, [], [
            $app->params['adminEmail'],

        ]);
    }


}
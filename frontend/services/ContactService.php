<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.01.2019
 * Time: 0:55
 */

namespace frontend\services;


use Yii;
use frontend\forms\ContactForm;
use http\Exception\RuntimeException;
use yii\mail\MailerInterface;

class ContactService
{
    //private $supportEmail;
    private $adminEmail;
    private $mailer;

    public function __construct($adminEmail, MailerInterface $mailer)
    {
        //$this->supportEmail = $supportEmail;
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function send(ContactForm $form)
    {
        $sent = $this->mailer->compose()

            ->setTo($this->adminEmail)
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();

        if (!$sent) {
            throw new RuntimeException('Ошибка отправки.');
        }
    }

}
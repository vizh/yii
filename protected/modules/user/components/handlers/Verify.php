<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 03.09.2015
 * Time: 13:21
 */

namespace user\components\handlers;

use mail\components\Mailer;
use mail\components\MailLayout;
use user\models\User;

class Verify extends MailLayout
{
    /** @var User */
    private $user;

    public function __construct(Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->user = $event->sender;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return \Yii::t('app', 'Активируйте аккаунт в сервисе');
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->getUser()->Email;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->renderBody('user.views.mail.verify', ['user' => $this->getUser()]);
    }

    /**
     * @return User
     */
    function getUser()
    {
        return $this->user;
    }
}
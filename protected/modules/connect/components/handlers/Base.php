<?php

namespace connect\components\handlers;

use connect\models\Meeting;
use mail\components\MailLayout;
use user\models\User;

abstract class Base extends MailLayout
{
    /** @var Meeting */
    protected $meeting;

    /** @var User */
    protected $user;

    /**
     * @param \mail\components\Mailer $mailer
     * @param \CEvent $event
     */
    public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->meeting = $event->params['meeting'];
        $this->user = $event->params['user'];
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'connect@runet-id.com';
    }

    /**
     * @inheritdoc
     */
    public function getFromName()
    {
        return '—RUNET—ID—';
    }

    public abstract function getViewPath();

    /**
     * Путь к шаблону письма
     * @return string
     */
    public function getViewName()
    {
        $dir = $this->getViewPath();
        $view = $this->meeting->Place->Event->IdName;
        if (is_file(\Yii::getPathOfAlias($dir).'/'.$view.'.php')){
            return $dir.'.'.$view;
        }
        else{
            return $dir.'.base';
        }
    }

    /**
     * @inheritdoc
     */
    public function getUser()
    {
        return $this->user;
    }
}
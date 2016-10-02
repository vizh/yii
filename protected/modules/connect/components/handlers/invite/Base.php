<?php

namespace connect\components\handlers\invite;

use connect\models\Meeting;
use mail\components\MailLayout;
use user\models\User;

class Base extends MailLayout
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
    public function getSubject()
    {
        return $this->meeting->Creator->getFullName().' предлагает Вам встретится';
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'support@forinnovations.ru';
    }

    /**
     * @inheritdoc
     */
    public function getFromName()
    {
        return 'Open Innovations 2016';
    }

    /**
     * @inheritdoc
     */
    public function getLayoutName()
    {
        return 'oi16';
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
        $params = [
            'meeting' => $this->meeting,
            'user' => $this->getUser()
        ];

        return $this->renderBody($this->getViewName(), $params);
    }

    /**
     * Путь к шаблону письма
     * @return string
     */
    public function getViewName()
    {
        $dir = 'connect.views.mail.invite';
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
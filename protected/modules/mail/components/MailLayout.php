<?php
namespace mail\components;

use event\models\Event;
use mail\models\Layout;
use user\models\User;

abstract class MailLayout extends Mail
{
    /**
     * Имя шаблона письма
     * @return string
     */
    public function getLayoutName()
    {
        return Layout::OneColumn;
    }

    /**
     * @return User
     */
    abstract function getUser();

    /**
     * @inheritdoc
     */
    public function isHtml()
    {
        return true;
    }

    /**
     * Отображать ссылку на отписку
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return true;
    }

    /**
     * @return null|Event
     */
    public function getRelatedEvent()
    {
        return null;
    }

    /**
     * Отображать footer письма
     * @return bool
     */
    public function showFooter()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function renderBody($view, $params)
    {
        $controller = new MailController($this);
        $layout = $controller->getLayoutFile($controller->layout);
        return $controller->renderFile($layout, ['content' => $controller->renderPartial($view, $params, true)], true);
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
    public function getToName()
    {
        return $this->getUser()->getFullName();
    }
}

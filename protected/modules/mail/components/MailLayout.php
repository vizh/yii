<?php
namespace mail\components;
use event\models\Event;
use \mail\models\Layout;
use user\models\User;

abstract class MailLayout extends Mail
{
    public function getLayoutName()
    {
        return Layout::OneColumn;
    }

    /**
     * @return User
     */
    abstract function getUser();

    public function isHtml()
    {
        return true;
    }

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
     * @return bool
     */
    public function showFooter()
    {
        return true;
    }

    protected function renderBody($view, $params)
    {
        $controller = new MailController($this);
        $layout = $controller->getLayoutFile($controller->layout);
        return $controller->renderFile($layout, ['content' => $controller->renderPartial($view, $params, true)], true);
    }
} 
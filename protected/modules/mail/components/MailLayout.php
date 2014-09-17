<?php
namespace mail\components;
use \mail\models\Layout;

abstract class MailLayout extends Mail
{
    public function getLayoutName()
    {
        return Layout::OneColumn;
    }

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
     * @return bool
     */
    public function showFooter()
    {
        return true;
    }

    protected function renderBody($view, $params)
    {
        $controller = new MailController($this->getUser(), $this->getLayoutName(), $this->showFooter(), $this->showUnsubscribeLink());
        $layout = $controller->getLayoutFile($controller->layout);
        return $controller->renderFile($layout, ['content' => $controller->renderPartial($view, $params, true)], true);
    }
} 
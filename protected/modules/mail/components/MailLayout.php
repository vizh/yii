<?php
namespace mail\components;

abstract class MailLayout extends \mail\components\Mail
{
  public function getLayoutName()
  {
    return \mail\models\Layout::OneColumn;
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

  public function showFooter()
  {
    return true;
  }

  protected function renderBody($view, $params)
  {
    $controller = new \mail\components\MailController($this->getUser(), $this->getLayoutName(), $this->showFooter(), $this->showUnsubscribeLink());
    $layout = $controller->getLayoutFile($controller->layout);
    return $controller->renderFile($layout, ['content' => $controller->renderPartial($view, $params, true)], true);
  }
} 
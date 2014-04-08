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

  protected function renderBody($view, $params)
  {
    $controller = new \mail\components\MailController($this->getUser(), $this->getLayoutName());
    $layout = $controller->getLayoutFile($controller->layout);
    return $controller->renderFile($layout, ['content' => $controller->renderPartial($view, $params, true)], true);
  }
} 
<?php

class AbstractWidget
{
  /**
   * @var View|string|null
   */
  protected $view = null;

  /**
   * @return AbstractCommand|null
   */
  protected function Command()
  {
    $frontController = FrontController::GetInstance();
    return $frontController->Command();
  }

  /**
   * @return View|null
   */
  protected function CommandView()
  {
    return $this->Command()->View();
  }

  public function __toString()
  {
    if (is_object($this->view))
    {
      return $this->view->__toString();
    }
    elseif (empty($this->view))
    {
      return '';
    }
    else
    {
      return $this->view;
    }
  }
}

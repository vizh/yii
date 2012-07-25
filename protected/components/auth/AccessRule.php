<?php
namespace application\components\auth;

class AccessRule extends \CAccessRule
{

  protected function isActionMatched($action)
  {
    return empty($this->actions) || in_array(strtolower($action), $this->actions);
  }

  protected function isControllerMatched($controller)
  {
    return empty($this->controllers) || in_array(strtolower($controller), $this->controllers);
  }
}

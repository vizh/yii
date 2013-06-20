<?php
namespace application\components\console;

class BaseConsoleCommand extends \CConsoleCommand
{
  protected function beforeAction($action, $params)
  {
    $_SERVER['SERVER_NAME'] = RUNETID_HOST;
    return parent::beforeAction($action, $params);
  }
}

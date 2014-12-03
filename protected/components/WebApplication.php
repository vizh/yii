<?php
namespace application\components;

/**
 * @property \application\components\auth\WebUser $user
 * @property \application\components\auth\WebUser $payUser
 * @property \partner\components\WebUser $partner
 *
 *
 * @property \partner\components\PhpAuthManager $partnerAuthManager
 * @property \ruvents\components\PhpAuthManager $ruventsAuthManager
 *
 * @property array $params
 */
class WebApplication extends \CWebApplication
{

  /**
   * Отключает логгеры, которые выводят результаты логгирования в output
   *
   * @return void
   */
  public function disableOutputLoggers()
  {
    $routes = \Yii::app()->log->getRoutes();
    foreach ($routes as $route)
    {
      if ($route instanceof \CProfileLogRoute || $route instanceof \CWebLogRoute)
      {
        $route->enabled = false;
      }
    }
  }
}
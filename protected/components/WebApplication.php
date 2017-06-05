<?php
namespace application\components;

use application\components\auth\WebUser;

/**
 * @property \application\components\auth\WebUser $user
 * @property \application\components\auth\WebUser $tempUser
 * @property \partner\components\WebUser $partner
 *
 *
 * @property \partner\components\PhpAuthManager $partnerAuthManager
 * @property \ruvents\components\PhpAuthManager $ruventsAuthManager
 *
 * @property array $params
 *
 * @method \CHttpRequest getRequest()
 * @method \CClientScript getClientScript()
 * @method \CAssetManager getAssetManager()
 * @method \CDbConnection getDb()
 * @method WebUser getUser()
 * @method \CHttpSession getSession()
 * @method \CCache getCache()
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
        foreach ($routes as $route) {
            if ($route instanceof \CProfileLogRoute || $route instanceof \CWebLogRoute) {
                $route->enabled = false;
            }
        }
    }
}
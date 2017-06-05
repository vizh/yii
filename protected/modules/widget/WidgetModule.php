<?php

class WidgetModule extends \CWebModule
{
    /**
     * The pre-filter for controller actions.
     * This method is invoked before the currently requested controller action and all its filters
     * are executed. You may override this method in the following way:
     * <pre>
     * if(parent::beforeControllerAction($controller,$action))
     * {
     *     // your code
     *     return true;
     * }
     * else
     *     return false;
     * </pre>
     * @param CController $controller the controller
     * @param CAction $action the action
     * @return boolean whether the action should be executed.
     */
    public function beforeControllerAction($controller, $action)
    {
        $redirectRoute = $controller->getId().'/'.$action->getId();
        \Yii::app()->getUser()->loginUrl = $controller->createUrl('auth/index', ['redirectRoute' => $redirectRoute]);
        return parent::beforeControllerAction($controller, $action);
    }

}
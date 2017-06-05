<?php
namespace application\components\auth;

class AccessRule extends \CAccessRule
{
    /**
     * @var string
     */
    public $module;

    /**
     * @param string $action
     * @return bool
     */
    protected function isActionMatched($action)
    {
        return empty($this->actions) || in_array(strtolower($action), $this->actions);
    }

    /**
     * @param string $controller
     * @return bool
     */
    protected function isControllerMatched($controller)
    {
        return empty($this->controllers) || in_array(strtolower($controller), $this->controllers);
    }

    /**
     * @param string $module
     * @return bool
     */
    protected function isModuleMatched($module)
    {
        return empty($this->module) || $this->module == $module;
    }

    /**
     * @param \CWebUser $user
     * @param string $module
     * @param string $controller
     * @param string $action
     * @param string $ip
     * @param string $verb
     * @return int
     */
    public function isUserAllowed($user, $module, $controller, $action, $ip, $verb = '')
    {
        $allowed = parent::isUserAllowed($user, $controller, $action, $ip, $verb);
        if ($this->isModuleMatched($module)) {
            return $allowed;
        } else {
            return 0;
        }
    }

}

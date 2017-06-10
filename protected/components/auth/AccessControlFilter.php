<?php
namespace application\components\auth;

class AccessControlFilter extends \CAccessControlFilter
{
    /** @var \CAccessRule */
    private $denyRule;

    protected function preFilter($filterChain)
    {
        $this->denyRule = null;
        if (!$this->checkAccess($filterChain->controller->getModule()->getId(), $filterChain->controller->getId(), $filterChain->action->getId())) {
            $this->accessDenied($this->getUser(), $this->resolveErrorMessage($this->denyRule));
            return false;
        }
        return true;
    }

    public function checkAccess($module, $controller, $action)
    {
        $request = \Yii::app()->getRequest();
        $user = $this->getUser();
        $verb = $request->getRequestType();
        $ip = $request->getUserHostAddress();

        foreach ($this->getRules() as $rule) {
            $allow = $rule->isUserAllowed($user, $module, $controller, $action, $ip, $verb);

            if ($allow > 0) // allowed
            {
                return true;
            } elseif ($allow < 0) // denied
            {
                $this->denyRule = $rule;
                return false;
            }
        }

        return true; // allowed by default
    }

    private $_rules = [];

    /**
     * @param array $rules list of access rules.
     */
    public function setRules($rules)
    {
        foreach ($rules as $rule) {
            if (is_array($rule) && isset($rule[0])) {
                $r = new AccessRule();
                $r->allow = $rule[0] === 'allow';
                foreach (array_slice($rule, 1) as $name => $value) {
                    if ($name === 'expression' || $name === 'roles' || $name === 'message' || $name === 'module') {
                        $r->$name = $value;
                    } else {
                        $r->$name = array_map('strtolower', $value);
                    }
                }
                $this->_rules[] = $r;
            }
        }
    }

    /**
     * @return AccessRule[]
     */
    public function getRules()
    {
        return $this->_rules;
    }

    /**
     * @return \CWebUser
     */
    protected function getUser()
    {
        return \Yii::app()->user;
    }
}
<?php
namespace application\components\auth;

class AccessControlFilter extends \CAccessControlFilter
{
  /** @var \CAccessRule */
  private $denyRule = null;
  protected function preFilter($filterChain)
  {
    $this->denyRule = null;
    if (!$this->checkAccess($filterChain->controller->getId(), $filterChain->action->getId()))
    {
      $this->accessDenied($this->getUser(), $this->resolveErrorMessage($this->denyRule));
      return false;
    }
    return true;
  }

  public function checkAccess($controller, $action)
  {
    $request = \Yii::app()->getRequest();
    $user = $this->getUser();
    $verb = $request->getRequestType();
    $ip = $request->getUserHostAddress();

    foreach($this->getRules() as $rule)
    {
      $allow = $rule->isUserAllowed($user, $controller, $action, $ip, $verb);

      if ($allow > 0) // allowed
      {
        return true;
      }
      elseif ($allow < 0) // denied
      {
        $this->denyRule = $rule;
        return false;
      }
    }

    return true; // allowed by default
  }

  private $_rules = array();

  /**
   * @param array $rules list of access rules.
   */
  public function setRules($rules)
  {
    foreach($rules as $rule)
    {
      if(is_array($rule) && isset($rule[0]))
      {
        $r = new AccessRule();
        $r->allow = $rule[0]==='allow';
        foreach(array_slice($rule,1) as $name=>$value)
        {
          if($name==='expression' || $name==='roles' || $name==='message')
            $r->$name=$value;
          else
            $r->$name=array_map('strtolower',$value);
        }
        $this->_rules[]=$r;
      }
    }
  }

  /**
   * @return \CAccessRule[]
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
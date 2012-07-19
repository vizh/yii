<?php
namespace partner\components;

class AccessControlFilter extends \CAccessControlFilter
{
  protected function preFilter($filterChain)
  {
    $app = \Yii::app();
    $request = $app->getRequest();
    $user = $app->partner;
    $verb = $request->getRequestType();
    $ip = $request->getUserHostAddress();

    foreach($this->getRules() as $rule)
    {
      if(($allow=$rule->isUserAllowed($user,$filterChain->controller,$filterChain->action,$ip,$verb))>0) // allowed
        break;
      else if($allow<0) // denied
      {
        $this->accessDenied($user,$this->resolveErrorMessage($rule));
        return false;
      }
    }

    return true;
  }
}

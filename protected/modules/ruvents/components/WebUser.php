<?php
namespace ruvents\components;

class WebUser extends \CWebUser
{
  private static $instance = null;

  /**
   * @static
   * @return WebUser
   */
  public static function Instance()
  {
    if (self::$instance === null)
    {
      self::$instance = new WebUser();
    }

    return self::$instance;
  }

  private $operator = null;
  private $alreadyTryLoad = false;

  /**
   * @return \ruvents\models\Operator
   */
  public function getOperator()
  {
    if ($this->operator === null && !$this->alreadyTryLoad)
    {
      $request = \Yii::app()->getRequest();
      $operatorId = $request->getParam('OperatorId');
      $hash = $request->getParam('Hash');
      /** @var $operator \ruvents\models\Operator */
      $operator = \ruvents\models\Operator::model()->findByPk($operatorId);
      if ($operator !== null && $operator->getAuthHash() === $hash
        && !$operator->isLoginExpire())
      {
        $this->operator = $operator;
      }
      $this->alreadyTryLoad = true;
    }

    return $this->operator;
  }

  public function resetOperator()
  {
    $this->operator = null;
    $this->alreadyTryLoad = false;
  }

  /**
   * @return null|string
   */
  public function getRole()
  {
    if ($this->getOperator() !== null)
    {
      return $this->getOperator()->Role;
    }
    return null;
  }

  protected $_access = array();

  public function checkAccess($operation,$params=array(),$allowCaching=true)
  {
    if($allowCaching && $params===array() && isset($this->_access[$operation]))
      return $this->_access[$operation];
    else
      return $this->_access[$operation]= \Yii::app()->ruventsAuthManager->checkAccess($operation,$this->getId(),$params);
  }

  public function getIsGuest()
  {
    return $this->getOperator() === null;
  }

  public function getId()
  {
    return $this->getOperator() !== null ? $this->getOperator()->Id : null;
  }
}
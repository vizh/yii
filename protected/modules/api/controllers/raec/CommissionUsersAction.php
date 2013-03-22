<?php
namespace api\controllers\raec;

class CommissionUsersAction extends \api\components\Action
{
  public function run()
  {
    $commissionId = \Yii::app()->getRequest()->getParam('CommissionId');
    /** @var $commission \commission\models\Commission */
    $commission = \commission\models\Commission::model()->findByPk($commissionId);
    if ($commission === null)
    {
      throw new \api\components\Exception(601, array($commissionId));
    }

    $result = array();
    foreach ($commission->Users as $user)
    {
      $this->getAccount()->getDataBuilder()->createUser($user->User);
      $this->getAccount()->getDataBuilder()->buildUserEmployment($user->User);
      $result['Users'][] = $this->getAccount()->getDataBuilder()->buildUserCommission($user->Role);
    }

    $this->setResult($result);
  }
}

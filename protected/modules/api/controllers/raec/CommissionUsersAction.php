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

    $builder = new \api\components\builders\Builder(null); //todo: быстрое решение, исправить

    $result = array();
    foreach ($commission->UsersActive as $user)
    {
      $builder->createUser($user->User);
      $builder->buildUserEmployment($user->User);
      $result['Users'][] = $builder->buildUserCommission($user->Role);
    }

    $this->setResult($result);
  }
}

<?php
namespace api\controllers\user;


class ProfessionalinterestsAction extends \api\components\Action
{
  public function run()
  {
    $crtieria = new \CDbCriteria();
    $crtieria->with = ['LinkProfessionalInterests.ProfessionalInterest'];

    $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
    $user = \user\models\User::model()->byRunetId($runetId)->find($crtieria);
    if ($user !== null)
    {
      $participant = \event\models\Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)->find();
      if ($participant === null)
      {
        throw new \api\components\Exception(202, array($runetId));
      }
    }
    else
      throw new \api\components\Exception(202, array($runetId));

    $result = [];
    foreach ($user->LinkProfessionalInterests as $link)
    {
      $result[] = $this->getDataBuilder()->createProfessionalInterest($link->ProfessionalInterest);
    }
    $this->setResult($result);
  }
} 
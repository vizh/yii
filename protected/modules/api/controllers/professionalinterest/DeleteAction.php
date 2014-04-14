<?php
namespace api\controllers\professionalinterest;


class DeleteAction extends \api\components\Action
{
  public function run()
  {
    $runetId = \Yii::app()->getRequest()->getParam('RunetId');
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user !== null)
    {
      $participant = \event\models\Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)->find();
      if ($participant === null)
      {
        throw new \api\components\Exception(202, [$runetId]);
      }
    }
    else
      throw new \api\components\Exception(202, [$runetId]);


    $professionalInterestId = \Yii::app()->getRequest()->getParam('ProfessionalInterestId');
    $link = \user\models\LinkProfessionalInterest::model()->byUserId($user->Id)->byProfessionalInterestId($professionalInterestId)->find();
    if ($link !== null)
    {
      $link->delete();
    }
    $this->setResult(['Success' => true]);
  }
} 
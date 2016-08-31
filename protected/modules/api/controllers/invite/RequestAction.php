<?php
namespace api\controllers\invite;

class RequestAction extends \api\components\Action
{
  public function run()
  {
    $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \api\components\Exception(202, [$runetId]);

    $request = \event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->byOwnerUserId($user->Id)->find();
    if ($request !== null)
      throw new \api\components\Exception(701, [$user->RunetId]);

    $request = new \event\models\InviteRequest();
    $request->SenderUserId = $request->OwnerUserId = $user->Id;
    $request->EventId = $this->getEvent()->Id;
    $request->save();
    $this->setSuccessResult();
  }
}
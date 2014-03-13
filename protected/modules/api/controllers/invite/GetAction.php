<?php
namespace api\controllers\invite;

class GetAction extends \api\components\Action
{
  public function run()
  {
    $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \api\components\Exception(202, [$runetId]);

    $request = \event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->byOwnerUserId($user->Id)->find();
    if ($request == null)
      throw new \api\components\Exception(702, [$user->RunetId]);

    $result = $this->getDataBuilder()->createInviteRequest($request);
    return $this->setResult($result);
  }
} 
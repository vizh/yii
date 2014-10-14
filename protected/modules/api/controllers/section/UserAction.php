<?php
namespace api\controllers\section;

class UserAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);
    if ($runetId === null)
    {
      $runetId = $request->getParam('RocId', null);
    }
    /** @var $user \user\models\User */
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user === null)
    {
      throw new \api\components\Exception(202, array($runetId));
    }

    $result = array();

    $criteria = new \CDbCriteria();
    $criteria->condition = '"LinkUsers"."UserId" = :UserId';
    $criteria->params = array('UserId' => $user->Id);

    /** @var $sections \event\models\section\Section[] */
    $sections = \event\models\section\Section::model()
        ->byEventId($this->getEvent()->Id)->byDeleted(false)
        ->with(array('LinkUsers' => array('together' => true)))->findAll($criteria);

    foreach ($sections as $section)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
    }

    $this->setResult($result);
  }
}

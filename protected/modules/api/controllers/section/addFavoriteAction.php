<?php
namespace api\controllers\section;

class AddFavoriteAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId');
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \api\components\Exception(202, [$runetId]);

    $sectionId = $request->getParam('SectionId');
    $section = \event\models\section\Section::model()->byDeleted(false)->findByPk($sectionId);
    if ($section === null)
      throw new \api\components\Exception(310, [$sectionId]);
    if ($section->EventId != $this->getEvent()->Id)
      throw new \api\components\Exception(311);

    $section->addToFavorite($user);
    $this->setResult(['Success' => true]);
  }
} 
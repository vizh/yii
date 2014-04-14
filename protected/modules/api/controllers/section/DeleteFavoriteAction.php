<?php
namespace api\controllers\section;

class DeleteFavoriteAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId');
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \api\components\Exception(202, [$runetId]);

    $sectionId = $request->getParam('SectionId');
    /** @var \event\models\section\Section $section */
    $section = \event\models\section\Section::model()->findByPk($sectionId);
    if ($section == null)
      throw new \api\components\Exception(310, [$sectionId]);
    if ($section->EventId != $this->getEvent()->Id)
      throw new \api\components\Exception(311);

    $favorite = \event\models\section\Favorite::model()
      ->byUserId($user->Id)->bySectionId($section->Id)->find();
    if ($favorite != null)
      $favorite->delete();

    $this->setResult(['Success' => true]);
  }
} 
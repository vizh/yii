<?php
namespace api\controllers\section;

class FavoritesAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId');
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \api\components\Exception(202, [$runetId]);

    $criteria = new \CDbCriteria();
    $criteria->addCondition('t."UserId" = :UserId')
      ->addCondition('"Section"."EventId" = :EventId');
    $criteria->with = ['Section' => ['together' => true, 'select'=> false]];
    $criteria->params = ['UserId' => $user->Id, 'EventId' => $this->getEvent()->Id];
    /** @var \event\models\section\Favorite[] $favorites */
    $favorites = \event\models\section\Favorite::model()->findAll($criteria);
    $result = [];
    foreach ($favorites as $favorite)
    {
      $result[] = $favorite->SectionId;
    }
    $this->setResult($result);
  }
} 
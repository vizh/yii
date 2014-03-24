<?php
namespace api\controllers\event;

class PurposesAction extends \api\components\Action
{
  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = ['Purpose'];
    $criteria->order = '"Purpose"."Title" ASC';
    $criteria->addCondition('"Purpose"."Visible"');
    $links = \event\models\LinkPurpose::model()->byEventId($this->getEvent()->Id)->findAll($criteria);

    $result = [];
    /** @var \event\models\LinkPurpose $link */
    foreach ($links as $link)
    {
      $result[] = $this->getDataBuilder()->createEventPuprose($link->Purpose);
    }
    $this->setResult($result);
  }
} 
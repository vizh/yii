<?php
namespace api\controllers\section;

class InfoAction extends \api\components\Action
{
  public function run()
  {
    $sectionId = \Yii::app()->getRequest()->getParam('SectionId');

    $section = \event\models\section\Section::model()->byDeleted(false)->findByPk($sectionId);
    if ($section === null)
        throw new \api\components\Exception(310, array($sectionId));
    if ($section->EventId != $this->getEvent()->Id)
        throw new \api\components\Exception(311);


    $this->setResult($this->getAccount()->getDataBuilder()->createSection($section));
  }
}

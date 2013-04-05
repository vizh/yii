<?php
namespace api\controllers\section;

class InfoAction extends \api\components\Action
{
  public function run()
  {
    $sectionId = \Yii::app()->getRequest()->getParam('SectionId');

    /** @var $section \event\models\section\Section */
    $section = \event\models\section\Section::model()->findByPk($sectionId);
    if ($section === null)
    {
      throw new \api\components\Exception(310, array($sectionId));
    }
    if ($section->EventId != $this->getEvent()->Id)
    {
      throw new \api\components\Exception(311);
    }

    $this->setResult($this->getAccount()->getDataBuilder()->createSection($section));
  }
}

<?php
namespace api\controllers\section;

class InfoAction extends \api\components\Action
{
  public function run()
  {
    $sectionId = \Yii::app()->getRequest()->getParam('SectionId');

    if ($this->getAccount()->Event === null)
    {
      throw new \api\components\Exception(301);
    }

    /** @var $section \event\models\section\Section */
    $section = \event\models\section\Section::model()->findByPk($sectionId);
    if ($section === null)
    {
      throw new \api\components\Exception(310, array($sectionId));
    }
    if ($section->EventId != $this->getAccount()->Event->Id)
    {
      throw new \api\components\Exception(311);
    }

    $this->setResult($this->getAccount()->getDataBuilder()->createSection($section));
  }
}

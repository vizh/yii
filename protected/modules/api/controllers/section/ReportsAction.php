<?php
namespace api\controllers\section;

class ReportsAction extends \api\components\Action
{
  public function run()
  {
    $sectionId = \Yii::app()->getRequest()->getParam('SectionId');

    if ($this->getAccount()->Event === null)
    {
      throw new \api\components\Exception(301);
    }

    /** @var $section \event\models\section\Section */
    $section = \event\models\section\Section::model()->with(
      array(
        'LinkUsers',
        'LinkUsers.User',
        'LinkUsers.User.Employments.Company' => array('on' => 'Employments.Primary'),
        'LinkUsers.Role',
        'LinkUsers.Report',
      )
    )->findByPk($sectionId);
    if (empty($section))
    {
      throw new \api\components\Exception(310, array($sectionId));
    }
    if ($section->EventId != $this->getAccount()->EventId)
    {
      throw new \api\components\Exception(311);
    }

    $result = array();
    foreach ($section->LinkUsers as $link)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createReport($link);
    }

    $this->setResult($result);
  }
}

<?php
namespace api\controllers\section;

class ReportsAction extends \api\components\Action
{
  public function run()
  {
    $sectionId = \Yii::app()->getRequest()->getParam('SectionId');

    /** @var $section \event\models\section\Section */
    $section = \event\models\section\Section::model()->byDeleted(false)->with(
      array(
        'LinkUsers',
        'LinkUsers.User',
        'LinkUsers.User.Employments.Company' => ['on' => '"Employments"."Primary"'],
        'LinkUsers.Role',
        'LinkUsers.Report',
      )
    )->findByPk($sectionId);
    if ($section === null)
        throw new \api\components\Exception(310, [$sectionId]);
    if ($section->EventId != $this->getEvent()->Id)
        throw new \api\components\Exception(311);

    $result = [];
    foreach ($section->LinkUsers as $link)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createReport($link);
    }

    $this->setResult($result);
  }
}

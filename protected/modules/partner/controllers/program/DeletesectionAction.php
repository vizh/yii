<?php
namespace partner\controllers\program;

use event\models\section\Section;

class DeletesectionAction extends \partner\components\Action
{

  public function run($sectionId = null)
  {
      $event = \Yii::app()->partner->getEvent();
      if ($sectionId != null)
      {
          $section = Section::model()->byEventId($event->Id)->byDeleted(false)->findByPk($sectionId);
          $section->useSoftDelete = true;
          $section->delete();
      }

      $this->getController()->redirect(\Yii::app()->createUrl('partner/program/index'));

  }
}

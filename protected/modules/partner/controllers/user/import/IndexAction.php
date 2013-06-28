<?php
namespace partner\controllers\user\import;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Импорт участников мероприятия');
    $this->getController()->initActiveBottomMenu('import');

    if (\Yii::app()->getRequest()->getIsPostRequest())
    {


      $file = \CUploadedFile::getInstanceByName('import_file');
      if ($file != null)
      {
        $import = new \partner\models\Import();
        $import->EventId = $this->getEvent()->Id;
        $import->save();
        $file->saveAs($import->getFileName());
        $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/importmap', ['id' => $import->Id]));
      }
    }

    $imports = \partner\models\Import::model()->findAll('"t"."EventId" = :EventId', [
      'EventId' => $this->getEvent()->Id
    ]);
    $this->getController()->render('import/index', ['imports' => $imports]);
  }
}
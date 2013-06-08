<?php
namespace partner\controllers\user;


class ImportAction extends \partner\components\Action
{
  public function run($importId = null)
  {
    if (empty($importId))
    {
      $this->listPage();
    }
    else
    {
      $this->importPage($importId);
    }
  }

  private function listPage()
  {

    if (\Yii::app()->getRequest()->getIsPostRequest())
    {
      $this->loadFile();
    }
    else
    {
      $imports = \partner\models\Import::model()->findAll('"t"."EventId" = :EventId', [
        'EventId' => $this->getEvent()->Id
      ]);
      $this->getController()->render('import/list', ['imports' => $imports]);
    }
  }

  private function loadFile()
  {
    $path = \Yii::getPathOfAlias('partner.data.'.$this->getEvent()->Id . '.import');
    if (!file_exists($path))
    {
      mkdir($path, 0755, true);
    }
    $fileName = $path . DIRECTORY_SEPARATOR . 'temp.csv';

    $form = new \partner\models\forms\user\ImportPrepare();
    $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
    if (!$form->validate())
    {
      $file = \CUploadedFile::getInstanceByName('import_file');
      $file->saveAs($fileName);
    }
    $parser = new \application\components\parsing\CsvParser($fileName);
    $parser->SetInEncoding('utf-8');
    $rows = $parser->Parse($form->getFields(), true);

    $activeFields = [];
    foreach ($rows as $row)
    {
      foreach ($row as $key => $value)
      {
        if (!empty($value) && !in_array($form->getFields()[$key], $activeFields))
        {
          $activeFields[] = $form->getFields()[$key];
        }
      }
    }

    if (!$form->hasErrors() && $form->checkActiveFields($activeFields))
    {
      $this->saveImportUsers($form, $rows);
    }
    else
    {
      $this->getController()->render('import/load', [
        'activeFields' => $activeFields,
        'rows' => array_slice($rows, 0, min(10, sizeof($rows))),
        'form' => $form
      ]);
    }
  }

  /**
   * @param \partner\models\forms\user\ImportPrepare $form
   * @param array $rows
   */
  private function saveImportUsers($form, $rows)
  {
    
  }

  private function importPage($importId)
  {
    $import = \partner\models\Import::model()->findByPk($importId);
    if ($import == null || $import->EventId != $this->getEvent()->Id)
    {
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/import'));
    }

    if (\Yii::app()->getRequest()->getIsPostRequest())
    {

    }
    else
    {

    }
  }
}
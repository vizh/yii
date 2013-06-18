<?php
namespace partner\controllers\user;

class ImportAction extends \partner\components\Action
{
  public function run($importId = null)
  {
    $this->getController()->setPageTitle('Импорт участников мероприятия');
    $this->getController()->initActiveBottomMenu('import');

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
      $import = $this->saveImportUsers($fileName, $form, $rows);
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/import',
        ['importId' => $import->Id])
      );
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
   *
   * @param string $fileName
   * @param \partner\models\forms\user\ImportPrepare $form
   * @param array $rows
   * @return \partner\models\Import
   */
  private function saveImportUsers($fileName, $form, $rows)
  {
    $import = new \partner\models\Import();
    $import->EventId = $this->getEvent()->Id;
    $attributes = $form->getAttributes();
    unset($attributes['Notify']);
    unset($attributes['NotifyEvent']);
    unset($attributes['Visible']);
    unset($attributes['Submit']);
    $import->Notify = $form->Notify;
    $import->NotifyEvent = $form->NotifyEvent;
    $import->Visible = $form->Visible;
    $import->Fields = base64_encode(serialize($attributes));
    $import->save();

    $newName = \Yii::getPathOfAlias('partner.data.'.$this->getEvent()->Id . '.import') . DIRECTORY_SEPARATOR . $import->Id.'.csv';
    rename($fileName, $newName);

    foreach ($rows as $row)
    {
      $importUser = new \partner\models\ImportUser();
      $importUser->ImportId = $import->Id;
      foreach ($row as $key => $value)
      {
        $field= $form->$key;
        if ($field !== null && $value !== null)
        {
          $importUser->$field = $value;
        }
      }
      $importUser->save();
    }

    return $import;
  }

  private function importPage($importId)
  {
    $import = \partner\models\Import::model()->findByPk($importId);
    if ($import == null || $import->EventId != $this->getEvent()->Id)
    {
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/import'));
    }

    if (!empty($import->Roles))
    {
      $this->parseUsers($import);
    }
    else
    {
      $this->importPageRoles($import);
    }
  }

  /**
   * @param \partner\models\Import $import
   */
  private function importPageRoles($import)
  {
    $roleNames = [];
    foreach ($import->Users as $user)
    {
      $roleNames[] = (string)$user->Role;
    }
    $roleNames = array_unique($roleNames);

    $values = \Yii::app()->getRequest()->getParam('values', array());


    $check = true;
    if (\Yii::app()->getRequest()->getIsPostRequest() && $check = $this->checkRoleValues($values))
    {
      $import->Roles = base64_encode(serialize($values));
      $import->save();
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/import', ['importId' => $import->Id]));
    }
    else
    {
      $error = null;
      if (!$check){
        $error = 'Необходимо заполнить все роли!';
      }

      $this->getController()->render('import/roles', [
        'roleNames' => $roleNames,
        'roles' => \event\models\Role::model()->findAll(['order' => '"Title"']),
        'values' => $values,
        'error' => $error
      ]);
    }
  }

  /**
   * @param array $values
   * @return bool
   */
  private function checkRoleValues($values)
  {
    foreach ($values as $key => $value)
    {
      if ($value == 0)
        return false;
    }
    return true;
  }

  /**
   * @param \partner\models\Import $import
   */
  private function parseUsers($import)
  {
    /** @var \partner\models\ImportUser[] $users */
    $users = $import->Users(['condition' => 'NOT "Users"."Imported"', 'limit' => 100]);
    if (sizeof($users) > 0)
    {
      foreach ($users as $user)
      {
        $user->parse($import, unserialize(base64_decode($import->Roles)));
      }
      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.\Yii::app()->createUrl('/partner/user/import', ['importId' => $import->Id]).'"></head><body></body></html>';;
    }
    else
    {
      $this->getController()->render('import/done');
    }
  }
}
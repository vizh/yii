<?php
namespace partner\controllers\user\import;

class ProcessAction extends \partner\components\Action
{
  public function run($id)
  {
    $import = \partner\models\Import::model()->findByPk($id);
    if ($import == null || $import->EventId != $this->getEvent()->Id)
      throw new \CHttpException(404);

    /** @var \partner\models\ImportUser[] $users */
    $users = \partner\models\ImportUser::model()
        ->byImportId($import->Id)->byImported(false)->byError(false)->findAll(['limit' => 100]);

    if (sizeof($users) == 0)
    {
      $model = \partner\models\ImportUser::model()
          ->byImportId($import->Id)->byError(true);
      if ($model->exists())
      {
        $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/importerrors', ['id' => $import->Id]));
      }
      else
      {
        $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/import'));
      }
    }
    else
    {
      foreach ($users as $user)
      {
        try
        {
          $user->parse($import, unserialize(base64_decode($import->Roles)));
        }
        catch (\partner\components\ImportException $e)
        {
          $user->Error = true;
          $user->ErrorMessage = $e->getMessage();
          $user->save();
        }
      }
      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.\Yii::app()->createUrl('/partner/user/importprocess', ['id' => $import->Id]).'"></head><body></body></html>';
    }
  }
}
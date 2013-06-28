<?php
namespace partner\controllers\user\import;


class ErrorsAction extends \partner\components\Action
{
  public function run($id)
  {
    $this->getController()->setPageTitle('Импорт участников мероприятия');
    $this->getController()->initActiveBottomMenu('import');

    $import = \partner\models\Import::model()->findByPk($id);
    if ($import == null || $import->EventId != $this->getEvent()->Id)
      throw new \CHttpException(404);

    /** @var \partner\models\ImportUser[] $users */
    $users = \partner\models\ImportUser::model()->byImportId($import->Id)->byError(true)->findAll();

    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $values = $request->getParam('users');

      foreach ($users as $user)
      {
        if (isset($values[$user->Id]))
        {
          $user->LastName = $values[$user->Id]['LastName'];
          $user->FirstName = $values[$user->Id]['FirstName'];
          $user->Email = $values[$user->Id]['Email'];
          $user->ErrorMessage = null;
          $user->Error = false;
          $user->save();
        }
      }

      $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/importprocess', ['id' => $import->Id]));
    }

    $this->getController()->render('import/errors', ['users' => $users]);
  }
}
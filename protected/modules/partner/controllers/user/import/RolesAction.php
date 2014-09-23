<?php
namespace partner\controllers\user\import;


class RolesAction extends \partner\components\Action
{
  public function run($id)
  {
    $import = \partner\models\Import::model()->findByPk($id);
    if ($import == null || $import->EventId != $this->getEvent()->Id)
      throw new \CHttpException(404);

    $request = \Yii::app()->getRequest();
    $roleNames = $this->getRoleNames($import);
    $values = $request->getParam('values', []);


    $check = true;
    if ($request->getIsPostRequest() && $check = $this->checkRoleValues($values))
    {
      $import->Roles = base64_encode(serialize($values));
      $import->save();
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/importproducts', ['id' => $import->Id]));
    }

    $this->getController()->render('import/roles', [
      'roleNames' => $roleNames,
      'roles' => $this->getEvent()->getRoles(),
      'values' => $values,
      'error' => !$check
    ]);
  }

  /**
   * @param \partner\models\Import $import
   * @return array
   */
  private function getRoleNames($import)
  {
    $roleNames = [];
    foreach ($import->Users as $user)
    {
      $roleNames[] = (string)$user->Role;
    }
    return array_unique($roleNames);
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
}
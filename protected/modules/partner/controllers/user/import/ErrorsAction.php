<?php
namespace partner\controllers\user\import;

use partner\models\Import;
use partner\models\ImportUser;

class ErrorsAction extends \partner\components\Action
{
    public function run($id)
    {
        $import = Import::model()->findByPk($id);
        if ($import == null || $import->EventId != $this->getEvent()->Id) {
            throw new \CHttpException(404);
        }

        /** @var ImportUser[] $users */
        $users = ImportUser::model()->byImportId($import->Id)->byError(true)->findAll();
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $values = $request->getParam('users');
            foreach ($users as $user) {
                $attributes = isset($values[$user->Id]) ? $values[$user->Id] : null;
                if (!empty($attributes)) {
                    $user->LastName = $attributes['LastName'];
                    $user->FirstName = $attributes['FirstName'];
                    $user->Email = $attributes['Email'];
                    $user->ErrorMessage = null;
                    $user->Error = false;
                    if (!empty($attributes['UserData'])) {
                        $user->UserData = json_encode($attributes['UserData'], JSON_UNESCAPED_UNICODE);
                    }
                    $user->save();
                }
            }
            $this->getController()->redirect(['importprocess', 'id' => $import->Id]);
        }
        $this->getController()->render('import/errors', ['users' => $users]);
    }
}
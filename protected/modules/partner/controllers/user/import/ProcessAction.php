<?php
namespace partner\controllers\user\import;

use partner\components\ImportException;
use partner\models\Import;
use partner\models\ImportUser;

class ProcessAction extends \partner\components\Action
{
    public function run($id)
    {
        ini_set('max_execution_time', 3600);

        $import = Import::model()->findByPk($id);
        if (!$import || $import->EventId != $this->getEvent()->Id) {
            throw new \CHttpException(404);
        }

        /** @var ImportUser[] $users */
        $users = ImportUser::model()
            ->byImportId($import->Id)
            ->byImported(false)
            ->byError(false)
            ->findAll(['limit' => 50]);

        if (sizeof($users)) {
            foreach ($users as $user) {
                try {
                    $user->parse(
                        $import,
                        unserialize(base64_decode($import->Roles)),
                        unserialize(base64_decode($import->Products))
                    );
                } catch (ImportException $e) {
                    $user->Error = true;
                    $user->ErrorMessage = $e->getMessage();
                    $user->save();
                }
            }

            echo '<html><head><meta http-equiv="REFRESH" content="0; url='.
                \Yii::app()->createUrl('/partner/user/importprocess', ['id' => $import->Id]).
                '"></head><body></body></html>';
        } else {
            $model = ImportUser::model()
                ->byImportId($import->Id)
                ->byError(true);

            if ($model->exists()) {
                $this->getController()->redirect(
                    \Yii::app()->createUrl('/partner/user/importerrors', ['id' => $import->Id])
                );
            } else {
                $this->getController()->redirect(
                    \Yii::app()->createUrl('/partner/user/import')
                );
            }
        }
    }
}

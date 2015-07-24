<?php
use user\models\User;
use application\components\controllers\AdminMainController;
use user\models\forms\admin\User as FormUser;
use application\helpers\Flash;


/**
 * Class EditController
 * @property \user\models\forms\admin\Edit $form
 * @property \user\models\User $user
 */
class EditController extends AdminMainController
{
    public function actionIndex($id = null, $backUrl = '')
    {
        $user = null;
        if ($id !== null) {
            $user = User::model()->byRunetId($id)->find();
            if ($user === null) {
                throw new \CHttpException(404);
            }
        }

        $form = new FormUser($user);
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess('Данные пользователя успешно сохранены!');
                $this->redirect(['index', 'id' => $result->RunetId, 'backUrl' => $backUrl]);
            }
        }
        $this->render('index', ['form' => $form, 'user' => $user, 'backUrl' => $backUrl]);
    }
} 
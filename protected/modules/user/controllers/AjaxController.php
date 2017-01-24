<?php
use mail\components\mailers\SESMailer;
use user\models\forms\RegisterForm;
use user\models\User;
use user\models\Document;
use application\components\controllers\PublicMainController;
use application\components\controllers\AjaxController as TraitAjaxController;
use user\components\handlers\Verify;
use application\components\helpers\ArrayHelper;

class AjaxController extends PublicMainController
{
    use TraitAjaxController;

    public function actions()
    {
        return [
            'phoneverify' => '\user\controllers\ajax\PhoneVerifyAction'
        ];
    }

    /**
     * Отправка email с ссылкой на подтверждение аккаунта пользователя
     */
    public function actionVerify()
    {
        $user = \Yii::app()->getUser()->getCurrentUser();
        if ($user !== null && !$user->Verified) {
            $mail = new Verify(new SESMailer(), new \CModelEvent($user));
            $mail->send();
        }
    }

    /**
     * @param $term
     * @param null $eventId
     */
    public function actionSearch($term, $eventId = null)
    {
        $results = array();
        $criteria = new \CDbCriteria();
        $criteria->limit = 10;
        $criteria->with = ['Employments.Company'];
        $model = User::model();

        if ($eventId !== null) {
            $event = \event\models\Event::model()->findByPk($eventId);
            if ($event){
                $model->bySearch($term, null, true, !isset($event->SearchHiddenUsers) || !$event->SearchHiddenUsers);
                if ($event->UserScope){
                    $model->byEventId($eventId);
                }
            }
            else{
                $model->bySearch($term);
            }
        } else {
            $model->bySearch($term);
        }

        if (Yii::app()->partner->role !== 'AdminExtended') {
            $role = Yii::app()->partnerAuthManager->roles[Yii::app()->partner->role];
            $available_roles = ArrayHelper::getValue($role->data, 'roles', []);
            if (!empty($available_roles)){
                $model->byEventRole($available_roles);
            }
        }

        /** @var $users \user\models\User[] */
        $users = $model->findAll($criteria);
        foreach ($users as $user) {
            $results[] = $this->getUserData($user);
        }
        echo json_encode($results);
    }

    public function actionRegister()
    {
        $result = new \stdClass();
        $request = \Yii::app()->getRequest();
        $form = new RegisterForm();
        $form->attributes = $request->getParam(get_class($form));

        if ($form->validate()) {
            $user = $this->createUser($form);
            $result->success = true;
            $result->user = $this->getUserData($user);
        } else {
            $user = \user\models\User::model()->byEmail($form->Email)->byVisible(true)->find();
            $isUserExist = $user !== null && $user->LastName === $form->LastName;
            if ($isUserExist) {
                $result->success = true;
                $result->user = $this->getUserData($user);
            } else {
                $result->success = false;
                $result->errors  = $form->getErrors();
            }
        }
        echo json_encode($result);
    }

    /**
     * Проверяет заполнен у пользователя документ, удостоверяющий личность
     * @param int $id
     */
    public function actionCheckDocument($id)
    {
        $user = User::model()->byRunetId($id)->find();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $result = new \stdClass();
        $result->result = Document::model()->byUserId($user->Id)->byActual(true)->exists();
        $result->user = $this->getUserData($user);
        echo json_encode($result);
    }

    /**
     * @param RegisterForm $form
     * @return User
     */
    private function createUser(RegisterForm $form)
    {
        $user = new \user\models\User();
        $user->LastName = $form->LastName;
        $user->FirstName = $form->FirstName;
        $user->FatherName = $form->FatherName;
        $user->Email = $form->Email;
        $user->PrimaryPhone = $form->Phone;
        $user->register();
        $user->setEmployment($form->Company, $form->Position);
        return $user;
    }

    /**
     * @return User|null
     */
    private function getCreator()
    {
        if (\Yii::app()->user->getCurrentUser() !== null) {
            return \Yii::app()->user->getCurrentUser();
        } elseif (\Yii::app()->tempUser->getCurrentUser() !== null) {
            return \Yii::app()->tempUser->getCurrentUser();
        }
        return null;
    }

    /**
     * @param User $user
     * @return stdClass
     */
    private function getUserData($user)
    {
        $data = ArrayHelper::toArray($user, ['user\models\User' => [
            'Id',
            'RunetId',
            'LastName',
            'FirstName',
            'FullName' => function (User $user) {
                return $user->getFullName();
            },
            'Photo' => function (User $user) {
                $photo = new \stdClass();
                $photo->Small  = $user->getPhoto()->get50px();
                $photo->Medium = $user->getPhoto()->get90px();
                $photo->Large  = $user->getPhoto()->get200px();
                return $photo;
            }
        ]]);
        $data['label'] = (string) $user;
        $data['value'] = $data['RunetId'];

        $employment = $user->getEmploymentPrimary();
        if (!empty($employment)) {
            $data['Company'] = $employment->Company->Name;
            $data['Position'] = trim($employment->Position);
        }
        return $data;
    }
}

<?php
namespace event\controllers\ajax;

use event\models\UserData;
use user\models\forms\RegisterForm;
use event\models\Event;
use user\models\User;

class UserRegisterAction extends \CAction
{
    private $event;

    public function run()
    {
        $result = new \stdClass();
        $request = \Yii::app()->getRequest();
        $form = new RegisterForm();
        $form->attributes = $request->getParam(get_class($form));

        $this->event = Event::model()->findByPk($form->EventId);
        if ($this->event == null) {
            throw new \CHttpException(500);
        }

        $userData = new UserData();
        $userData->EventId = $form->EventId;
        $userData->CreatorId = $this->getCreator() !== null ? $this->getCreator()->Id : null;
        $dataManager = $userData->getManager();
        $dataManagerValidate = true;
        if ($request->getParam(get_class($dataManager)) !== null) {
            $dataManager->setAttributes($request->getParam(get_class($dataManager)));
            $dataManagerValidate = $dataManager->validate();
        }

        if ($form->validate() && $dataManagerValidate) {
            $user = $this->createUser($form);
            $result->success = true;
            $result->user = $this->getUserData($user);

            if ($dataManager->hasDefinitions()) {
                $userData->UserId = $user->Id;
                $userData->save();
            }
        } else {
            $user = User::model()->byEmail($form->Email)->byVisible(true)->find();
            $isUserExist = $user !== null && $user->LastName === $form->LastName;
            if ($isUserExist && $dataManagerValidate) {
                $result->success = true;
                $result->user = $this->getUserData($user);

                if ($dataManager->hasDefinitions()) {
                    $userData->UserId = $user->Id;
                    $userData->save();
                }
            } elseif($isUserExist) {
                $result->success = false;
                $result->errors  = $dataManager->getErrors();
            } else {
                $result->success = false;
                $result->errors  = array_merge($form->getErrors(), $dataManager->getErrors());
            }
        }
        echo json_encode($result);
    }

    private function createUser(RegisterForm $form)
    {
        $user = new User();
        $user->LastName = $form->LastName;
        $user->FirstName = $form->FirstName;
        $user->FatherName = $form->FatherName;
        $user->Email = $form->Email;
        $user->PrimaryPhone = $form->Phone;
        $user->register();
        if (isset($this->event->UnsubscribeNewUser) && $this->event->UnsubscribeNewUser == 1) {
            $user->Settings->UnsubscribeAll = true;
            $user->Settings->save();
        }
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
        } elseif (\Yii::app()->payUser->getCurrentUser() !== null) {
            return \Yii::app()->payUser->getCurrentUser();
        }
        return null;
    }

    /**
     * @param User $user
     * @return stdClass
     */
    private function getUserData($user)
    {
        $data = new \stdClass();
        $data->RunetId = $data->value = $user->RunetId;
        $data->LastName = $user->LastName;
        $data->FirstName = $user->FirstName;
        $data->FullName = $data->label = $user->getFullName();
        $data->Photo = new \stdClass();
        $data->Photo->Small = $user->getPhoto()->get50px();
        $data->Photo->Medium = $user->getPhoto()->get90px();
        $data->Photo->Large = $user->getPhoto()->get200px();
        if ($user->getEmploymentPrimary() !== null)
        {
            $data->Company = $user->getEmploymentPrimary()->Company->Name;
            $data->Position = trim($user->getEmploymentPrimary()->Position);
        }
        return $data;
    }
} 
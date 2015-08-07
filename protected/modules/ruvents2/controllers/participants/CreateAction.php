<?php
namespace ruvents2\controllers\participants;

use event\models\Part;
use event\models\Role;
use ruvents2\components\Action;
use ruvents2\components\data\UserBuilder;
use ruvents2\components\Exception;
use user\models\forms\RegisterForm;
use user\models\User;

class CreateAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $form = new RegisterForm(RegisterForm::SCENARIO_RUVENTS);
        $form->LastName = $request->getParam('LastName');
        $form->FirstName = $request->getParam('FirstName');
        $form->FatherName = $request->getParam('FatherName');
        $form->Company = $request->getParam('Company');
        $form->Position = $request->getParam('Position');

        $form->Email = $request->getParam('Email');
        $form->Phone = $request->getParam('Phone');
        $form->Visible = $request->getParam('Visible');

        if (empty($form->Email)) {
            $form->Email = 'nomail'.$this->getEvent()->Id.'+'.substr(md5($form->FirstName . $form->LastName . $form->Company . mt_rand()), 0, 8).'@runet-id.com';
        }

        if ($form->validate()) {
            $transaction = \Yii::app()->getDb()->beginTransaction();
            try {
                $user = $form->register();
                $this->updateStatuses($user);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } else {
            throw Exception::createInvalidParam(array_keys($form->getErrors()));
        }

        $user = UserBuilder::create()
            ->setEvent($this->getEvent())
            ->setApiAccount($this->getApiAccount())
            ->setUser($user)
            ->build();

        $this->renderJson($user);
    }

    /**
     * @param User $user
     * @throws Exception
     */
    private function updateStatuses($user)
    {
        $statuses = json_decode(\Yii::app()->getRequest()->getParam('Statuses'));
        if (empty($statuses))
            throw new Exception(Exception::NEW_PARTICIPANT_EMPTY_STATUS);

        if (count($this->getEvent()->Parts) == 0) {
            if (count($statuses) == 1) {
                $role = Role::model()->findByPk($statuses[0]->StatusId);
                if ($role == null)
                    throw Exception::createInvalidParam('Statuses', 'Не найден статус с Id: ' . $statuses[0]->StatusId);
                $this->getEvent()->registerUser($user, $role);
            } else {
                throw Exception::createInvalidParam('Statuses', 'Для мероприятия без частей в массиве Statuses должен быть ровно один элемент.');
            }
        } else {
            foreach ($statuses as $status) {
                $role = Role::model()->findByPk($status->StatusId);
                if ($role == null)
                    throw Exception::createInvalidParam('Statuses', 'Не найден статус с Id: ' . $status->StatusId);
                $part = Part::model()->byEventId($this->getEvent()->Id)->findByPk($status->PartId);
                if ($part == null)
                    throw Exception::createInvalidParam('Statuses', 'Не найдена часть мероприятия с Id: ' . $status->PartId);

                $this->getEvent()->registerUserOnPart($part, $user, $role);
            }
        }
    }
}
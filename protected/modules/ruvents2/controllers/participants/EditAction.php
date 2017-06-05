<?php
namespace ruvents2\controllers\participants;

use event\models\Part;
use event\models\Role;
use ruvents2\components\Action;
use ruvents2\components\data\builders\UserBuilder;
use ruvents2\components\Exception;
use user\models\User;
use Yii;

class EditAction extends Action
{
    public function run($Id = null)
    {
        /* Если Id посетителя не получен из строки запроса, то пробуем
         * считать его из параметров запроса. Это необходимо для
         * значительного упрощения работы клиента. */
        if ($Id == null) {
            Yii::app()->getRequest()->getPost("Id");
        }

        $user = User::model()->byRunetId($Id)->find();

        if ($user == null) {
            throw new Exception(Exception::INVALID_PARTICIPANT_ID, $Id);
        }

        $this->updateStatuses($user);

        /* Построение результата */
        $this->renderJson(
            UserBuilder::create()
                ->setEvent($this->getEvent())
                ->setApiAccount($this->getApiAccount())
                ->setUser($user)
                ->build()
        );
    }

    /**
     * @param User $user
     * @throws Exception
     */
    private function updateStatuses($user)
    {
        $statuses = json_decode(Yii::app()->getRequest()->getParam('Statuses'));
        if (empty($statuses)) {
            throw new Exception(Exception::NEW_PARTICIPANT_EMPTY_STATUS);
        }

        if (count($this->getEvent()->Parts) == 0) {
            if (count($statuses) == 1) {
                $role = Role::model()->findByPk($statuses[0]->StatusId);
                if ($role == null) {
                    throw Exception::createInvalidParam('Statuses', 'Не найден статус с Id: '.$statuses[0]->StatusId);
                }
                $this->getEvent()->registerUser($user, $role);
            } else {
                throw Exception::createInvalidParam('Statuses', 'Для мероприятия без частей в массиве Statuses должен быть ровно один элемент.');
            }
        } else {
            foreach ($statuses as $status) {
                $role = Role::model()->findByPk($status->StatusId);
                if ($role == null) {
                    throw Exception::createInvalidParam('Statuses', 'Не найден статус с Id: '.$status->StatusId);
                }
                $part = Part::model()->byEventId($this->getEvent()->Id)->findByPk($status->PartId);
                if ($part == null) {
                    throw Exception::createInvalidParam('Statuses', 'Не найдена часть мероприятия с Id: '.$status->PartId);
                }

                $this->getEvent()->registerUserOnPart($part, $user, $role);
            }
        }
    }
}
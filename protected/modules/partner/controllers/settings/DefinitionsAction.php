<?php
namespace partner\controllers\settings;

use application\helpers\Flash;
use application\models\attribute\Group;
use event\models\Event;
use event\models\forms\UserAttributeGroup;
use event\models\Participant;
use event\models\UserData;
use partner\components\Action;
use Yii;

class DefinitionsAction extends Action
{
    public function run()
    {
        ini_set('memory_limit', '1024M');

        $request = Yii::app()->getRequest();

        if ($request->isPostRequest) {
            $form = $this->getEditableForm();
            $form->fillFromPost();

            if ($attribute = $request->getParam('EraseData')) {
                $changesPresent = $this->eraseAttributeData($attribute);
                Flash::setSuccess($changesPresent ? "Данные атриута $attribute очищены." : "Все значения $attribute уже были пусты");
                $this->getController()->refresh();
            }

            if ($request->getParam('GroupData') === 'true') {
                $this->groupUsers($this->getEvent());
                Flash::setSuccess('Пользователи перераспределены по группам');
                $this->getController()->refresh();
            }

            $result = $form->isUpdateMode()
                ? $form->updateActiveRecord()
                : $form->createActiveRecord();

            if ($result) {
                Flash::setSuccess(Yii::t('app', 'Атрибуты успешно сохранены!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('definitions', [
            'event' => $this->getEvent(),
            'forms' => $this->getForms()
        ]);
    }

    /** @var null|UserAttributeGroup[] */
    private $forms = null;

    /**
     * @return UserAttributeGroup[]
     */
    private function getForms()
    {
        if ($this->forms === null) {
            $this->forms = [];
            $groups = Group::model()
                ->byModelName('EventUserData')
                ->byModelId($this->getEvent()->Id)
                ->orderBy('"t"."Order"')
                ->findAll();

            foreach ($groups as $group) {
                $this->forms[] = new UserAttributeGroup($this->getEvent(), $group);
            }
            $this->forms[] = new UserAttributeGroup($this->getEvent());
        }

        return $this->forms;
    }

    /**
     * @return UserAttributeGroup|null
     */
    private function getEditableForm()
    {
        $id = (int)Yii::app()
            ->getRequest()
            ->getParam('Id');

        foreach ($this->getForms() as $form) {
            if ($form->isUpdateMode() && $form->getActiveRecord()->Id !== $id) {
                continue;
            }

            return $form;
        }

        return null;
    }

    /**
     * Erases data of an attribute
     *
     * @param string $attribute
     * @return bool
     */
    private function eraseAttributeData($attribute)
    {
        /** @var UserData[] $usersData */
        $usersData = UserData::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll();

        $changesPresent = false;

        foreach ($usersData as $userData) {
            $dataManager = $userData->getManager();
            if (isset($dataManager->$attribute)) {
                unset($dataManager->$attribute);
                $userData->save(false);
                $changesPresent = true;
            }
        }

        return $changesPresent;
    }

    /**
     * Применяет группировку данных для мероприятий Food ingredients Russia 2016 и IPhEB&CPhI Russia 2016
     */
    private function groupUsers(Event $event)
    {
        $groupData = [
            14001 => 0,
            14002 => 0,
            14003 => 0,
            14004 => 0
        ];

        $usersData = UserData::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll();

        /* Построем кеш участия пользователей дабы
         * избежать лишней серии запросов к базе */
        $participations = [];

        /* Ищем максимальные из уже существующих индексы */
        foreach ($usersData as $userData) {
            $dataManager = $userData->getManager();

            $participant = Participant::model()
                ->byEventId($this->getEvent()->Id)
                ->byUserId($userData->UserId)
                ->find();

            if ($participant == null) {
                continue;
            }

            $participations[$userData->UserId]
                = $participant->RoleId;

            if (!isset($dataManager->ean17) || empty($dataManager->ean17)) {
                continue;
            }

            $group = $this->participantGroup($event, $participant->RoleId);

            if ($group == null) {
                continue;
            }

            $index = (int)substr($dataManager->ean17, 5);

            if ($groupData[$group] < $index) {
                $groupData[$group] = $index;
            }
        }

        foreach ($usersData as $userData) {
            if (!isset($participations[$userData->UserId])) {
                continue;
            }

            $dataManager = $userData->getManager();

            /* Не трогаем тех, кому номер уже присвоен */
            if (isset($dataManager->ean17) && !empty($dataManager->ean17)) {
                continue;
            }

            $group = $this->participantGroup($event, $participations[$userData->UserId]);

            /* Нет группы, нет номера. Всё просто. */
            if ($group === null) {
                continue;
            }

            $index = $groupData[$group] + 1;
            $groupData[$group] = $index;

            /* Присваеваем номер */
            $dataManager->ean17
                = sprintf('%d%07d', $group, $index);

            $userData->save(false);
        }
    }

    private function participantGroup(Event $event, $RoleId)
    {
        if (in_array($RoleId, [12, 216, 213, 110, 217, 6])) {
            return $event->Id == 2514 ? 14001 : 14003;
        }

        if (in_array($RoleId, [38, 215, 2, 14, 3])) {
            return $event->Id == 2514 ? 14002 : 14004;
        }

        return null;
    }
}
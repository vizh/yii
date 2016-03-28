<?php
namespace partner\controllers\settings;

use application\helpers\Flash;
use application\models\attribute\Group;
use event\models\forms\UserAttributeGroup;
use event\models\Participant;
use event\models\UserData;
use partner\components\Action;
use Yii;

class DefinitionsAction extends Action
{
    public function run()
    {
        ini_set('memory_limit', '512M');

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
                $this->groupUsersByStatus();
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
            $groups = Group::model()->byModelName('EventUserData')->byModelId($this->getEvent()->Id)->orderBy('"t"."Order"')->findAll();
            foreach ($groups as $group) {
                $this->forms[] = new UserAttributeGroup($this->getEvent(), $group);
            }
            $this->forms[] = new UserAttributeGroup($this->getEvent());
        }
        return $this->forms;
    }

    /**
     * @return UserAttributeGroup
     */
    private function getEditableForm()
    {
        $id = Yii::app()->getRequest()->getParam('Id');
        foreach ($this->getForms() as $form) {
            if ($form->isUpdateMode() && $form->getActiveRecord()->Id != $id) {
                continue;
            }
            return $form;
        }
    }

    /**
     * Erases data of an attribute
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
    private function groupUsersByStatus()
    {
        $groupData = [
            14001 => 0,
            14002 => 0
        ];

        $usersData = UserData::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll();

        foreach ($usersData as $userData) {
            $participant = Participant::model()
                ->byEventId($this->getEvent()->Id)
                ->byUserId($userData->UserId)
                ->find();
            /* Вычисляем группу пользователя в зависимости от его роли */
            $group = null;
            if (in_array($participant->RoleId, [12, 216, 213, 110, 217, 6]))
                $group = 14001;
            elseif (in_array($participant->RoleId, [38, 215, 2, 14, 3]))
                $group = 14002;
            /* Если посетитель не относится ни к одной группе, то пропускаем его */
            if ($group === null)
                continue;

            $index = $groupData[$group] + 1;
                     $groupData[$group] = $index;

            $dataManager = $userData->getManager();
            $dataManager->ean17 = sprintf('%d%07d', $group, $index);
            $userData->save(false);
        }
    }
}
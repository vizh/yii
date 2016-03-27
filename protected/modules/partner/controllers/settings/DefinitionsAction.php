<?php
namespace partner\controllers\settings;

use application\helpers\Flash;
use application\models\attribute\Group;
use event\models\forms\UserAttributeGroup;
use event\models\UserData;
use partner\components\Action;

class DefinitionsAction extends Action
{
    public function run()
    {
        if (\Yii::app()->getRequest()->isPostRequest) {
            $form = $this->getEditableForm();
            $form->fillFromPost();

            if ($attribute = \Yii::app()->getRequest()->getParam('EraseData')) {
                $changesPresent = $this->eraseAttributeData($attribute);
                Flash::setSuccess($changesPresent ? "Данные атриута $attribute очищены." : "Все значения $attribute уже были пусты");
                $this->getController()->refresh();
            }

            $result = $form->isUpdateMode()
                ? $form->updateActiveRecord()
                : $form->createActiveRecord();

            if ($result) {
                Flash::setSuccess(\Yii::t('app', 'Атрибуты успешно сохранены!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('definitions', ['forms' => $this->getForms()]);
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
        $id = \Yii::app()->getRequest()->getParam('Id');
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
}
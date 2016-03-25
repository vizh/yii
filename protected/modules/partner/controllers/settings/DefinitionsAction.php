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
                if ($this->eraseAttributeData($attribute)) {
                    \Yii::app()->getUser()->setFlash('success', "Данные атриута $attribute очищены.");
                    $this->getController()->refresh();
                }
            }

            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
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
        /** @var UserData[] $items */
        $items = UserData::model()->findAll([
            'condition' => '"EventId" = :eventId',
            'params' => [':eventId' => $this->getController()->getEvent()->Id]
        ]);

        try {
            foreach ($items as $item) {
                $data = json_decode($item->Attributes, true);
                if (isset($data[$attribute])) {
                    unset($data[$attribute]);
                    $item->Attributes = json_encode($item->Attributes, JSON_UNESCAPED_UNICODE);
                    $item->save();
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
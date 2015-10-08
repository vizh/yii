<?php
namespace partner\controllers\settings;

use application\helpers\Flash;
use application\models\attribute\Group;
use event\models\forms\UserAttributeGroup;
use partner\components\Action;

class DefinitionsAction extends Action
{
    public function run()
    {
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form = $this->getEditableForm();
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
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
}
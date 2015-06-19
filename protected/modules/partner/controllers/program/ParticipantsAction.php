<?php
namespace partner\controllers\program;

use application\helpers\Flash;
use event\models\section\LinkUser;
use event\models\section\Section;
use partner\components\Action;
use partner\models\forms\program\Participant;

class ParticipantsAction extends Action
{
    public function run($id)
    {
        $event = $this->getEvent();
        $section = Section::model()->byEventId($event->Id)->byDeleted(false)->findByPk($id);
        if ($section === null) {
            throw new \CHttpException(404);
        }

        $forms = $this->initForms($section);

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form = $this->getEditableForm($section, $forms);
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', 'Информация о участнике секции успешно сохранена!'));
                $this->getController()->redirect(['participants', 'id' => $section->Id]);
            }
        }

        $this->getController()->render('participants', [
            'section' => $section,
            'forms' => $forms
        ]);
    }

    /**
     * @param Section $section
     * @return Participant[]
     */
    private function initForms(Section $section)
    {
        $forms[0] = new Participant($section);
        $links = LinkUser::model()->byDeleted(false)->bySectionId($section->Id)->orderBy(['"t"."Order"' => SORT_ASC, '"t"."Id"' => SORT_ASC])->findAll();
        foreach ($links as $link) {
            $forms[] = new Participant($section, $link);
        }
        return $forms;
    }

    /**
     * @param Section $section
     * @param Participant[] $forms
     * @return Participant
     * @throws \CHttpException
     */
    private function getEditableForm(Section $section, $forms)
    {
        $id = \Yii::app()->getRequest()->getParam('ParticipantId');
        if ($id !== null) {
            foreach ($forms as $form) {
                if ($form->isUpdateMode() && $form->getActiveRecord()->Id == $id) {
                    return $form;
                }
            }
            throw new \CHttpException(404);
        } else {
            return $forms[0];
        }
    }
}

<?php
namespace partner\controllers\program;

use application\helpers\Flash;
use \event\models\section\Section;
use \partner\models\forms\program\Section as SectionForm;

class SectionAction extends \partner\components\Action
{
    public function run($id = null)
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $section = null;

        if ($id !== null) {
            $section = Section::model()
                ->byEventId($this->getEvent()->Id)
                ->byDeleted(false)
                ->findByPk($id);

            if ($section === null) {
                throw new \CHttpException(404);
            }
        }

        $form = new SectionForm($this->getEvent(), $section, $request->getParam('locale'));

        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $section = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($section !== null) {
                Flash::setSuccess(\Yii::t('app','Информация о секции успешно сохранена!'));
                $this->getController()->redirect(['section', 'id' => $section->Id, 'locale' => $form->getLocale()]);
            }
        }

        $this->getController()->render('section', [
            'form' => $form
        ]);
    }
}

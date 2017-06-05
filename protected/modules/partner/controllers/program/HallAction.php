<?php
namespace partner\controllers\program;

use application\helpers\Flash;
use event\models\section\Hall;
use partner\models\forms\program\Hall as HallForm;

class HallAction extends \partner\components\Action
{
    private $locale;

    public function run()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();

        /** @var HallForm[] $forms */
        $forms = [];

        $halls = Hall::model()->byEventId($this->getEvent()->Id)->byDeleted(false)->orderBy(['"Order"' => SORT_ASC, '"Title"' => SORT_ASC])->findAll();
        foreach ($halls as $hall) {
            $forms[] = new HallForm($this->getEvent(), $hall, $request->getParam('locale'));
        }

        if ($request->getIsPostRequest()) {
            $valid = true;
            foreach ($forms as $form) {
                $form->fillFromPost();
                if (!$form->validate()) {
                    $valid = false;
                }
            }

            if ($valid) {
                foreach ($forms as $form) {
                    $form->updateActiveRecord();
                }

                Flash::setSuccess(\Yii::t('app', 'Информация о залах успешно сохранена!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('hall', ['forms' => $forms]);
    }
}
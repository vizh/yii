<?php
namespace user\controllers\edit;

use application\helpers\Flash;
use user\models\Document;
use user\models\DocumentType;
use user\models\forms\document\BaseDocument;

class DocumentAction extends \CAction
{
    public function run()
    {
        $forms = $this->initForms();

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form = $this->getEditableForm($forms);
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', '{document} успешно сохранен.', ['{document}' => $result->Type->Title]));
                $this->getController()->redirect(['', 'tab' => $form->getDocumentType()->FormName]);
            }
        } else {
            $this->activateForm($forms);
        }
        $this->getController()->render('document', ['forms' => $forms]);
    }

    /**
     * @return BaseDocument[]
     */
    private function initForms()
    {
        $forms = [];

        $user = \Yii::app()->getUser()->getCurrentUser();

        $types = DocumentType::model()->orderBy('"t"."Id"')->findAll();
        foreach ($types as $type) {
            $document = Document::model()->byUserId($user->Id)->byTypeId($type->Id)->byActual(true)->find();
            $class = '\user\models\forms\document\\'.$type->FormName;
            $forms[] = new $class($type, $user, $document);
        }
        return $forms;
    }

    /**
     * @param BaseDocument[] $forms
     * @return BaseDocument
     * @throws \CHttpException
     */
    private function getEditableForm($forms)
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        foreach ($forms as $form) {
            if ($request->getParam(get_class($form)) !== null) {
                $form->activate();
                return $form;
            }
        }
        throw new \CHttpException(404);
    }

    /**
     * @param BaseDocument[] $forms
     */
    private function activateForm($forms)
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        foreach ($forms as $form) {
            if ($request->getParam('tab') === $form->getDocumentType()->FormName) {
                $form->activate();
            }
        }
    }
} 
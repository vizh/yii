<?php
use application\components\controllers\AdminMainController;
use application\helpers\Flash;
use user\models\Document;
use user\models\DocumentType;
use user\models\forms\document\BaseDocument;
use user\models\User;

class DocumentController extends AdminMainController
{
    public function actionEdit($id, $backUrl = null)
    {
        $user = User::model()->byRunetId($id)->find();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $forms = $this->initForms($user);

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form = $this->getEditableForm($forms);
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', '{document} успешно сохранен.', ['{document}' => $result->Type->Title]));
                $this->refresh();
            }
        }

        $this->render('edit', ['user' => $user, 'forms' => $forms, 'backUrl' => $backUrl]);
    }

    /**
     * @param User $user
     * @return BaseDocument[]
     */
    private function initForms(User $user)
    {
        $forms = [];
        $types = DocumentType::model()->orderBy('"t"."Id"')->findAll();
        foreach ($types as $type) {
            $document = Document::model()->byUserId($user->Id)->byTypeId($type->Id)->byActual(true)->find();
            $forms[] = $type->getForm($user, $document);
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
                return $form;
            }
        }
        throw new \CHttpException(404);
    }
} 
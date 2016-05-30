<?php

use mail\models\Template;
use mail\models\forms\admin\Template as TemplateForm;
use application\components\controllers\AdminMainController;
use application\helpers\Flash;
use application\components\utility\Paginator;
use mail\components\mailers\MandrillMailer;

class TemplateController extends AdminMainController
{
    /**
     * Список всех рассылок
     */
    public function actionIndex()
    {
        $paginator = new Paginator(Template::model()->count());
        $paginator->perPage = \Yii::app()->getParams()['AdminMailPerPage'];
        $templates = Template::model()->orderBy(['"t"."Id"' => SORT_DESC])->findAll($paginator->getCriteria());
        $this->render('index', ['templates' => $templates, 'paginator' => $paginator]);
    }

    /**
     * Редактирование или создание шаблона рассылки
     * @param int $id
     * @throws CHttpException
     */
    public function actionEdit($id = null)
    {
        $template = null;
        if ($id !== null) {
            $template = Template::model()->findByPk($id);
            if ($template === null) {
                throw new \CHttpException(404);
            }

            if ($template->Active) {
                Flash::setError('Рассылка была активирована, внесни изменения невозможно!');
            }
        }

        $form = new TemplateForm($template);
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $template = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($template !== null) {
                Flash::setSuccess($form->Test ? 'Тестовая рассылка успешно отправлена' : 'Рассылка успешно сохранена');
                $this->redirect(['edit', 'id' => $template->Id]);
            }
        }

        $this->render('edit', [
            'form' => $form
        ]);
    }

    /**
     * Удаление приложенного файла к рассылке
     * @param int $id
     * @param string $file
     * @throws CHttpException
     */
    public function actionDeleteAttachment($id, $file)
    {
        $template = Template::model()->findByPk($id);
        if ($template === null) {
            throw new \CHttpException(404);
        }

        $form = new TemplateForm($template);
        $path = $form->getPathAttachments() . DIRECTORY_SEPARATOR . $file;
        if (file_exists($path)) {
            unlink($path);
        }
        $this->redirect(['edit','id' => $template->Id]);
    }

    /**
     * Rollback the mail template
     *
     * @param int $id Identifier of the mail
     * @throws CHttpException
     */
    public function actionRollback($id)
    {
        if (!$template = Template::model()->findByPk($id)) {
            throw new CHttpException(404);
        }

        $template->rollback();

        $this->redirect(['edit', 'id' => $template->Id]);
    }
}

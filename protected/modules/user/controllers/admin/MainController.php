<?php
use application\components\controllers\AdminMainController;
use application\helpers\Flash;
use user\models\forms\admin\Merge as MergeForm;
use user\models\search\admin\Contacts;
use user\models\User;

class MainController extends AdminMainController
{
    /**
     * Поиск контактов пользователей
     */
    public function actionContacts()
    {
        $search = new Contacts();
        $this->render('contacts', ['search' => $search]);
    }

    /**
     * Обьединение пользователей
     * @param int|null $idPrimary
     * @param int|null $idSecond
     */
    public function actionMerge($idPrimary = null, $idSecond = null)
    {
        $primary = User::model()->byRunetId($idPrimary)->find();
        $second = User::model()->byRunetId($idSecond)->find();
        if (!empty($primary) && !empty($second)) {
            $form = new MergeForm($primary, $second);
            if (\Yii::app()->getRequest()->getIsPostRequest()) {
                $form->fillFromPost();
                if ($form->updateActiveRecord() !== null) {
                    Flash::setSuccess('Пользователи успешно обьединены. <br/>'.\CHtml::link('Основной пользователь', $form->getActiveRecord()->getUrl()));
                    $this->redirect(['merge']);
                }
            }

            $this->render('merge/merge', ['form' => $form]);
        } else {
            $this->render('merge');
        }
    }
}
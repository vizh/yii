<?php
namespace partner\controllers\user;

use partner\components\Action;
use partner\models\forms\user\Find;
use user\models\User;

/**
 * Class FindAction
 * @package partner\controllers\user
 */
class FindAction extends Action
{
    public function run()
    {
        $form = new Find();
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->validate()) {
                $user = User::model()->bySearch($form->Label, null, true, false)->byEmail($form->Label, false)->find();
                if (!empty($user)) {
                    $this->getController()->redirect(['edit', 'id' => $user->RunetId]);
                }
            }
        }
        $this->getController()->render('find', ['form' => $form]);
    }
}
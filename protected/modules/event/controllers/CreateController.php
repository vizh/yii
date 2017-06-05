<?php
use event\models\forms\Create as Form;

class CreateController extends \application\components\controllers\PublicMainController
{
    public function actionIndex()
    {
        $request = \Yii::app()->getRequest();
        $form = new Form();
        $form->attributes = $request->getParam(get_class($form));

        if (\Yii::app()->getUser()->getIsGuest()) {
            $form->addError('ContactName', '<a href="#" id="PromoLogin">Авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID для добавления мероприятия');
        }

        if ($request->getIsPostRequest() && $form->validate(null, false)) {
            $form->save($form);
            $this->refresh();
        }

        $this->render('index', ['form' => $form]);
    }
}

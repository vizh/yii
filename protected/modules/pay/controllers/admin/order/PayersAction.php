<?php
namespace pay\controllers\admin\order;

use pay\models\forms\admin\PayersFilter;

class PayersAction extends \CAction
{
    public function run()
    {
        $this->getController()->setPageTitle('Список плательщиков юридических счетов и квитанций');
        $request = \Yii::app()->getRequest();

        $users = null;
        $form = new PayersFilter();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getParam('find') !== null && $form->validate()) {
            $users = $form->getUsers();
        }
        $this->getController()->render('payers', ['form' => $form, 'users' => $users]);
    }
} 
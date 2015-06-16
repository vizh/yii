<?php
namespace partner\controllers\orderitem;

use partner\components\Action;
use partner\models\forms\orderitem\Create;
use partner\models\search\OrderItems;

class CreateAction extends Action
{
    public function run()
    {
        $form = new Create($this->getEvent());

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $orderItem = $form->createActiveRecord();
            if ($orderItem !== null) {
                $this->getController()->redirect(
                    ['index', \CHtml::activeName(new OrderItems($this->getEvent()), 'Id') => $orderItem->Id]
                );
            }
        }

        $this->getController()->render('create', ['form' => $form]);
    }
}

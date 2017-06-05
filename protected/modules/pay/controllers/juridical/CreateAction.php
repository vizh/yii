<?php
namespace pay\controllers\juridical;

use pay\components\Action;
use pay\components\collection\Finder;
use pay\models\forms\Juridical;

class CreateAction extends Action
{
    public function run($eventIdName)
    {
        $this->getController()->setPageTitle('Выставление счета  / '.$this->getEvent()->Title.' / RUNET-ID');

        if ($this->getAccount()->OrderLastTime !== null && $this->getAccount()->OrderLastTime < date('Y-m-d H:i:s')) {
            throw new \CHttpException(404);
        }

        $finder = Finder::create($this->getEvent()->Id, $this->getUser()->Id);
        $collection = $finder->getUnpaidFreeCollection();
        if ($collection->count() == 0) {
            $this->getController()->redirect($this->getController()->createUrl('/pay/cabinet/index'));
        }

        $form = new Juridical($this->getEvent(), $this->getUser());
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->createActiveRecord() !== null) {
                $this->getController()->redirect($form->getOrder()->getUrl());
            }
        }
        $this->getController()->render('create', [
            'form' => $form,
            'account' => $this->getAccount()
        ]);
    }
}

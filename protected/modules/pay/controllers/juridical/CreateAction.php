<?php
namespace pay\controllers\juridical;

use pay\components\collection\Finder;
use pay\models\forms\Juridical;
use pay\models\Order;
use pay\models\OrderType;

class CreateAction extends \pay\components\Action
{
    public function run($eventIdName)
    {
        $this->getController()->setPageTitle('Выставление счета  / ' . $this->getEvent()->Title . ' / RUNET-ID');

        if ($this->getAccount()->OrderLastTime !== null && $this->getAccount()->OrderLastTime < date('Y-m-d H:i:s'))
            throw new \CHttpException(404);

        $finder = Finder::create($this->getEvent()->Id, $this->getUser()->Id);
        $collection = $finder->getUnpaidFreeCollection();
        if ($collection->count() == 0)
            $this->getController()->redirect($this->getController()->createUrl('/pay/cabinet/index'));

        $form = new Juridical();
        $request = \Yii::app()->getRequest();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $request->getParam(get_class($form)) !== null && $form->validate()) {
            $order = new Order();
            $order->create($this->getUser(), $this->getEvent(), OrderType::Juridical, $form->attributes);
            $this->getController()->redirect(['/pay/order/index', 'orderId' => $order->Id, 'hash' => $order->getHash()]);
        }

        $this->getController()->render('create', array(
            'form' => $form,
            'account' => $this->getAccount()
        ));
    }
}

<?php
namespace widget\controllers\pay;

class JuridicalAction extends \widget\components\pay\Action
{
    public function run()
    {
        if ($this->getAccount()->OrderLastTime !== null && $this->getAccount()->OrderLastTime < date('Y-m-d H:i:s'))
            throw new \CHttpException(404);

        $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->getUser()->Id);
        $collection = $finder->getUnpaidFreeCollection();
        if ($collection->count() == 0)
            $this->getController()->redirect($this->getController()->createUrl('/widget/pay/cabinet'));

        $form = new \pay\models\forms\Juridical();
        $request = \Yii::app()->getRequest();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $request->getParam(get_class($form)) !== null && $form->validate())
        {
            $order = new \pay\models\Order();
            $order->create($this->getUser(), $this->getEvent(), \pay\models\OrderType::Juridical, $form->attributes);
            echo '
                <script>
                    top.location.href=\''. $order->getUrl() .'\';
                </script>
            ';
            \Yii::app()->end();
        }

        $this->getController()->render('juridical', array(
            'form' => $form
        ));
    }
}
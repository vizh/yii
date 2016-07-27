<?php
namespace pay\controllers\cabinet;

use pay\models\EventUserAdditionalAttribute;
use pay\models\Failure;
use \pay\models\forms\AddtionalAttributes as FormAdditionalAttributes;

class IndexAction extends \pay\components\Action
{
    public function run($eventIdName)
    {
        $request = \Yii::app()->getRequest();
        $this->getController()->setPageTitle('Оплата  / ' .$this->getEvent()->Title . ' / RUNET-ID');

        \partner\models\PartnerCallback::start($this->getEvent());
        if ($this->getUser() != null)
        {
            \partner\models\PartnerCallback::registration($this->getEvent(), $this->getUser());
        }

        $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->getUser()->Id);
        $unpaidItems = new \stdClass();
        $unpaidItems->all = [];
        $unpaidItems->tickets = [];
        $unpaidItems->callbacks = [];

        foreach ($finder->getUnpaidFreeCollection() as $item)
        {
            switch ($item->getOrderItem()->Product->ManagerName) {
                case 'Ticket': $key = 'tickets';
                    break;
                case 'Callback': $key = 'callbacks';
                    break;
                default: $key = 'all';
            }

            if (!isset($unpaidItems->{$key}[$item->getOrderItem()->ProductId]))
            {
                $unpaidItems->{$key}[$item->getOrderItem()->ProductId] = [];
            }
            $unpaidItems->{$key}[$item->getOrderItem()->ProductId][] = $item;
            //добавим в лог попытку оплаты
            Failure::setAttempt($item->getOrderItem());
        }

        $formAdditionalAttributes = $this->getAdditionalAttributesForm($finder);
        $this->processAdditionalAttributesForm($formAdditionalAttributes);



        $allPaidCollections = array_merge($finder->getPaidOrderCollections(), $finder->getPaidFreeCollections());

        $hasRecentPaidItems = false;
        foreach ($allPaidCollections as $collection)
        {
            foreach ($collection as $item)
            {
                /** @var $item \pay\components\OrderItemCollectable */
                if ($item->getOrderItem()->PaidTime > date('Y-m-d H:i:s', time() - 10*60*60))
                {
                    $hasRecentPaidItems = true;
                    break;
                }
            }
            if ($hasRecentPaidItems)
                break;
        }



        $this->getController()->render('index', array(
            'finder' => $finder,
            'unpaidItems' => $unpaidItems,
            'hasRecentPaidItems' => $hasRecentPaidItems,
            'account' => $this->getAccount(),
            'formAdditionalAttributes' => $formAdditionalAttributes
        ));
    }

    /**
     * @param \pay\components\collection\Finder $finder
     * @return \pay\models\forms\AddtionalAttributes
     */
    private function getAdditionalAttributesForm(\pay\components\collection\Finder $finder)
    {
        $attributes = [];
        $values = [];
        foreach ($finder->getUnpaidFreeCollection() as $item)
        {
            $product = $item->getOrderItem()->Product;
            foreach ($product->getAdditionalAttributes() as $attr)
            {
                $attributes[$attr->Name] = $attr;
                $value = \pay\models\EventUserAdditionalAttribute::model()->byEventId($this->getEvent()->Id)->byUserId($this->getUser()->Id)->byName($attr->Name)->find();
                if ($value !== null) {
                    $values[$value->Name] = $value->Value;
                }
            }
        }

        usort($attributes, function ($a, $b) {
            if ($a->Order == $b->Order) {
                return 0;
            }
            return ($a->Order < $b->Order) ? -1 : 1;
        });

        $form = new FormAdditionalAttributes($attributes, $values);
        return $form;
    }

    /**
     * Проверяет наличие формы дополнительных параметров и производит валидацию
     * @param FormAdditionalAttributes $form
     */
    private function processAdditionalAttributesForm(FormAdditionalAttributes $form)
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($form->getIsEmpty() || !$request->getIsPostRequest() || $request->getParam('checkAdditionalAttributes') == null) {
            return;
        }

        $form->setAttributes($request->getParam(get_class($form)));
        $result = ['success' => false];
        if ($form->validate()) {
            foreach ($form->attributeNames() as $name) {
                $attribute = EventUserAdditionalAttribute::model()->byEventId($this->getEvent()->Id)->byUserId($this->getUser()->Id)->byName($name)->find();
                if ($attribute == null) {
                    $attribute = new EventUserAdditionalAttribute();
                    $attribute->EventId = $this->getEvent()->Id;
                    $attribute->UserId = $this->getUser()->Id;
                    $attribute->Name = $name;
                }
                $attribute->Value = $form->$name;
                $attribute->save();
            }
            $result['success'] = true;
        } else {
            $result['errors'] = $form->getErrors();
        }
        echo json_encode($result);
        \Yii::app()->end();
    }

}
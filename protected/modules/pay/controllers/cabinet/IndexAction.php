<?php
namespace pay\controllers\cabinet;

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
        }

        $formAdditionalAttributes = $this->getAddtionalAttributesForm($finder);
        if (!$formAdditionalAttributes->getIsEmpty())
        {
            $formAdditionalAttributes->attributes = $request->getParam(get_class($formAdditionalAttributes));
            if ($request->getIsPostRequest() && $formAdditionalAttributes->validate())
            {
                $this->processAddtionalAttributesForm($formAdditionalAttributes);
            }
        }



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
    private function getAddtionalAttributesForm(\pay\components\collection\Finder $finder)
    {
        $title = null;
        $attributes = [];
        $values = [];
        foreach ($finder->getUnpaidFreeCollection() as $item)
        {
            $product = $item->getOrderItem()->Product;
            foreach ($product->getAdditionalAttributes() as $attr)
            {
                $attributes[$attr->Name] = $attr;
                $value = \pay\models\EventUserAdditionalAttribute::model()->byEventId($this->getEvent()->Id)->byUserId($this->getUser()->Id)->byName($attr->Name)->find();
                if ($value !== null)
                {
                    $values[$value->Name] = $value->Value;
                }

                if (!empty($product->AdditionalAttributesTitle))
                {
                    $title = $product->AdditionalAttributesTitle;
                }
            }
        }

        usort($attributes, function ($a, $b) {
            if ($a->Order == $b->Order) {
                return 0;
            }
            return ($a->Order < $b->Order) ? -1 : 1;
        });

        $form = new \pay\models\forms\AddtionalAttributes($attributes, $values);
        $form->FormTitle = $title;
        return $form;
    }

    /**
     * @param \pay\models\forms\AddtionalAttributes $form
     */
    private function processAddtionalAttributesForm(\pay\models\forms\AddtionalAttributes $form)
    {
        foreach ($form->attributeNames() as $name)
        {
            $attribute = \pay\models\EventUserAdditionalAttribute::model()->byEventId($this->getEvent()->Id)->byUserId($this->getUser()->Id)->byName($name)->find();
            if ($attribute == null)
            {
                $attribute = new \pay\models\EventUserAdditionalAttribute();
                $attribute->EventId = $this->getEvent()->Id;
                $attribute->UserId = $this->getUser()->Id;
                $attribute->Name = $name;
            }
            $attribute->Value = $form->$name;
            $attribute->save();
        }
        $this->getController()->redirect($form->SuccessUrl);
    }

}
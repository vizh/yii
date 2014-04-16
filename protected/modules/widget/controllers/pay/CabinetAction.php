<?php
namespace widget\controllers\pay;

class CabinetAction extends \widget\components\pay\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->getUser()->Id);
    $unpaidItems = new \stdClass();
    $unpaidItems->all = [];
    $unpaidItems->tickets = [];
    foreach ($finder->getUnpaidFreeCollection() as $item)
    {
      $key = $item->getOrderItem()->Product->ManagerName == 'Ticket' ? 'tickets' : 'all';
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

    $this->processAction();

    $this->getController()->render('cabinet', array(
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

  private function processAction()
  {
    $request = \Yii::app()->getRequest();
    $action = $request->getParam('action');
    if ($action !== null)
    {
      $method = 'processAction'.ucfirst($action);
      if (method_exists($this, $method))
      {
        $this->$method();
      }
      $this->getController()->redirect(['/widget/pay/cabinet']);
    }
  }

  private function processActionOrderDelete()
  {
    $request = \Yii::app()->getRequest();
    $order = \pay\models\Order::model()->findByPk($request->getParam('orderId'));
    if ($order !== null && $order->EventId == $this->getEvent()->Id && $order->PayerId == $this->getUser()->Id)
    {
      $order->delete();
    }
  }

} 
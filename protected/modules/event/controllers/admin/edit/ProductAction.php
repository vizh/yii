<?php
namespace event\controllers\admin\edit;

class ProductAction extends \CAction
{
  private $formProducts = [];
  private $formNewProduct;
  private $event;
  
  public function run($eventId)
  {
    $this->event= \event\models\Event::model()->findByPk($eventId);
    if ($this->event == null)
      throw new \CHttpException(404);

    $criteria = new \CDbCriteria();
    $criteria->condition = 't."ManagerName" != :ManagerName';
    $criteria->params = ['ManagerName' => 'RoomProductManager'];
    $criteria->order = 't."Id"';
    foreach (\pay\models\Product::model()->byEventId($this->event->Id)->findAll($criteria) as $product)
    {
      $formProduct = new \pay\models\forms\Product($this->event, $product);
      foreach ($product->Prices as $price)
      {
        $formPrice = new \pay\models\forms\ProductPrice();
        $formPrice->setAttributes($price->getAttributes());
        $formProduct->Prices[] = $formPrice;
      }
      
      foreach ($product->getProductAttributes() as $attr)
      {
        $formProduct->Attributes[$attr->Name] = $attr->Value;
      }

      foreach($product->getAdditionalAttributes() as $attr)
      {
        $formAdditionalAttribute = new \pay\models\forms\AdditionalAttribute();
        $formAdditionalAttribute->Name  = $attr->Name;
        $formAdditionalAttribute->Label = $attr->Label;
        $formAdditionalAttribute->Type  = $attr->Type;
        $formAdditionalAttribute->Order = $attr->Order;
        $formProduct->AdditionalAttributes[] = $formAdditionalAttribute;
      }

      $this->formProducts[] = $formProduct;
    }
    
    if (\Yii::app()->getRequest()->getIsPostRequest())
    {
      $this->processPostRequest();
    }
    
    if ($this->formNewProduct == null)
    {
      $this->formNewProduct = new \pay\models\forms\Product($this->event);
    }
    
    \Yii::app()->getClientScript()->registerPackage('runetid.backbone');
    $this->getController()->setPageTitle(\Yii::t('app', 'Настройка товаров для мероприятия &laquo;{event}&raquo;', ['{event}' => $this->event->Title]));
    $this->getController()->render('product', [
      'event' => $this->event,
      'formProducts' => $this->formProducts,
      'formNewProduct' => $this->formNewProduct
    ]);
  }
  
  /**
   * 
   */
  private function processPostRequest()
  {
    $form = new \pay\models\forms\Product($this->event);
    $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
    $form->clearPrices();
    if ($form->validate())
    {
      $product = $form->getProduct();
      if ($product == null)
      {
        $product = new \pay\models\Product();
        $product->EventId = $this->event->Id;
      }
      else if (!empty($form->Delete))
      {
        $product->delete();
        foreach ($product->Prices as $price)
          $price->delete();
        
        foreach ($product->Attributes as $attribute)
          $attribute->delete();
        
        $this->successAndRefresh();
      }
      
      $product->Title = $form->Title;
      $product->Description = !empty($form->Description) ? $form->Description : null;
      $product->EnableCoupon = $form->EnableCoupon == 1 ? true : false;
      $product->Public = $form->Public == 1 ? true : false;
      $product->Priority = $form->Priority;
      $product->Unit = $form->Unit;
      $product->ManagerName = $form->ManagerName;

      $additionalAttributes = [];
      foreach($form->AdditionalAttributes as $formAdditionalAttribute)
      {
        $additionalAttribute = new \pay\models\AdditionalAttribute();
        $additionalAttribute->Name  = $formAdditionalAttribute->Name;
        $additionalAttribute->Label = $formAdditionalAttribute->Label;
        $additionalAttribute->Type  = $formAdditionalAttribute->Type;
        $additionalAttribute->Order = $formAdditionalAttribute->Order;
        $additionalAttributes[] = $additionalAttribute;
      }
      $product->setAdditionalAttributes($additionalAttributes);

      $product->save();
      
      foreach ($form->Attributes as $name => $value)
      {
        $attribute = \pay\models\ProductAttribute::model()->byProductId($product->Id)->byName($name)->find();
        if ($attribute == null)
        {
          $attribute = new \pay\models\ProductAttribute();
          $attribute->ProductId = $product->Id;
          $attribute->Name = $name;
        }
        $attribute->Value = $value;
        $attribute->save();
      }
      
      foreach ($form->Prices as $formPrice)
      {
        if (!empty($formPrice->Id))
        {
          $price = \pay\models\ProductPrice::model()->findByPk($formPrice->Id);
        }
        else
        {
          $price = new \pay\models\ProductPrice();
          $price->ProductId = $product->Id;
        }
       
        $price->Price = $formPrice->Price;
        $price->Title = !empty($formPrice->Title) ? $formPrice->Title : null;
        $price->StartTime = $formPrice->getStartTime();
        $price->EndTime   = $formPrice->getEndTime();
        $price->save();
      }

      $this->successAndRefresh();
    }
    else
    {
      if (!empty($form->Id))
      {
        foreach ($this->formProducts as $i => $formProduct)
        {
          if ($formProduct->Id == $form->Id)
          {
            $this->formProducts[$i] = $form;
            break;
          }
        }
      }
      else
      {
        $this->formNewProduct = $form;
      }
    }
  }
  
  /**
   * 
   */
  private function successAndRefresh()
  {
    \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Информация о товарах сохранена!'));
    $this->getController()->refresh();
  }
}

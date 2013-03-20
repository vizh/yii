<?php
class PayController extends convert\components\controllers\Controller 
{
  public function actionAccount()
  {
    $accounts = $this->queryAll('SELECT * FROM `Mod_PayAccount` ORDER BY `AccountId` ASC');
    foreach ($accounts as $account)
    {
      $newAccount = new \pay\models\Account();
      $newAccount->EventId = $account['EventId'];
      $newAccount->Own = true;
      if (!empty($account['JuridicalParams']))
      {
        $newAccount->OrderTemplateName = $account['JuridicalParams'];
      }
      if (!empty($account['PayRedirectUrl']))
      {
        $newAccount->ReturnUrl = $account['PayRedirectUrl'];
      }
      $newAccount->save();
    }
  }
  
  public function actionCoupon()
  {
    $coupons = $this->queryAll('SELECT * FROM `Mod_PayCoupon` ORDER BY `CouponId` ASC');
    foreach ($coupons as $coupon)
    {
      $newCoupon = new \pay\models\Coupon();
      $newCoupon->Id = $coupon['CouponId'];
      $newCoupon->EventId = $coupon['EventId'];
      if (!empty($coupon['ProductId']))
      {
        $newCoupon->ProductId = $coupon['ProductId'];
      }
      $newCoupon->Code = $coupon['Code'];
      $newCoupon->Discount = $coupon['Discount'];
      if (!empty($coupon['Recipient']))
      {
        $newCoupon->Recipient = $coupon['Recipient'];
      }
      if ($coupon['Multiple'] > 0)
      {
        $newCoupon->Multiple = true;
        $newCoupon->MultipleCount = $coupon['Multiple'];
      }
      if ($coupon['CreationTime'] != '0000-00-00 00:00:00')
      {
        $newCoupon->CreationTime = $coupon['CreationTime'];
      }
      if (!empty($coupon['EndTime']))
      {
        $newCoupon->EndTime = $coupon['EndTime'];
      }
      $newCoupon->save();
    }
  }
  
  public function actionCouponactivation()
  {
    $activations = $this->queryAll('SELECT * FROM `Mod_PayCouponActivated` ORDER BY `CouponActivatedId` ASC');
    foreach ($activations as $activation)
    {
      $newActivation = new \pay\models\CouponActivation();
      $newActivation->Id = $activation['CouponActivatedId'];
      $newActivation->CouponId = $activation['CouponId'];
      $newActivation->UserId = $activation['UserId'];
      if ($activation['CreationTime'] != '0000-00-00 00:00:00')
      {
        $newActivation->CreationTime = $activation['CreationTime'];
      }
      $newActivation->save();
    }
  }
  
  public function actionCaloi()
  {
    $links = $this->queryAll('SELECT * FROM `Mod_PayCouponActivatedOrderItemLink` ORDER BY `LinkId` ASC');
    foreach ($links as $link)
    {
      $newLink = new \pay\models\CouponActivationLinkOrderItem();
      $newLink->Id = $link['LinkId'];
      $newLink->CouponActivationId = $link['CouponActivatedId'];
      $newLink->OrderItemId = $link['OrderItemId'];
      $newLink->save();
    }
  }
  
  public function actionOrder()
  {
    $orders = $this->queryAll('SELECT `Mod_PayOrder`.`OrderId` as `Id`, `Mod_PayOrder`.*, `Mod_PayOrderJuridical`.* FROM `Mod_PayOrder`
      LEFT OUTER JOIN `Mod_PayOrderJuridical` ON `Mod_PayOrderJuridical`.`OrderId` = `Mod_PayOrder`.`OrderId`'
    );
    foreach ($orders as $order)
    {
      $newOrder = new \pay\models\Order();
      $newOrder->Id = $order['Id'];
      $newOrder->PayerId = $order['PayerId'];
      $newOrder->EventId = $order['EventId'];
      if (!empty($order['OrderJuricalId']))
      {
        $newOrder->Juridical = true;
        $newOrder->Paid = $order['Paid'] == 1 ? true : false;
        $newOrder->Deleted = $order['Deleted'] == 1 ? true : false;
      }
      $newOrder->CreationTime = $order['CreationTime'];
      $newOrder->save();
    }
  }
  
  public function actionOrderitem()
  {
    $items = $this->queryAll('SELECT * FROM `Mod_PayOrderItem` ORDER BY `OrderItemId` ASC');
    foreach ($items as $item)
    {
      $newItem = new \pay\models\OrderItem();
      $newItem->Id = $item['OrderItemId'];
      $newItem->ProductId = $item['ProductId'];
      $newItem->PayerId = $item['PayerId'];
      $newItem->OwnerId = $item['OwnerId'];
      if (!empty($item['RedirectId']))
      {
        $newItem->ChangedOwnerId = $item['RedirectId'];
      }
      if (!empty($item['Booked']))
      {
        $newItem->Booked = $item['Booked'];
      }
      $newItem->Paid = $item['Paid'] == 1 ? true : false;
      if (!empty($item['PaidTime']))
      {
        $newItem->PaidTime = $item['PaidTime'];
      }
      if ($item['CreationTime'] != '0000-00-00 00:00:00')
      {
        $newItem->CreationTime = $item['CreationTime'];
      }
      $newItem->Deleted = $item['Deleted'] == 1 ? true : false;
      $newItem->save();
    }
  }
  
  public function actionOrderitemattr()
  {
    $attributes = $this->queryAll('SELECT * FROM `Mod_PayOrderItemParam` ORDER BY `OrderItemParamId` ASC');
    foreach ($attributes as $attr)
    {
      $newAttr = new \pay\models\OrderItemAttribute();
      $newAttr->Id = $attr['OrderItemParamId'];
      $newAttr->OrderItemId = $attr['OrderItemId'];
      $newAttr->Name = $attr['Name'];
      $newAttr->Value = $attr['Value'];
      $newAttr->save();
    }
  }
  
  public function actionJuridical()
  {
    $juridicals = $this->queryAll('SELECT * FROM `Mod_PayOrderJuridical` ORDER BY `OrderJuricalId` ASC ');
    foreach ($juridicals as $juridical)
    {
      $newJur = new \pay\models\OrderJuridical();
      $newJur->Id = $juridical['OrderJuricalId'];
      $newJur->OrderId = $juridical['OrderId'];
      $newJur->Name = $juridical['Name'];
      $newJur->Address = $juridical['Address'];
      $newJur->INN = $juridical['INN'];
      $newJur->KPP = $juridical['KPP'];
      $newJur->Phone = $juridical['Phone'];
      $newJur->Fax = $juridical['Fax'];
      $newJur->PostAddress = $juridical['PostAddress'];
      $newJur->save();
    }
  }
  
  public function actionOloi()
  {
    $links = $this->queryAll('SELECT * FROM `Mod_PayOrderItemLink` ORDER BY `LinkId` ASC');
    foreach ($links as $link)
    {
      $newLink = new \pay\models\OrderLinkOrderItem();
      $newLink->Id = $link['LinkId'];
      $newLink->OrderId = $link['OrderId'];
      $newLink->OrderItemId = $link['OrderItemId'];
      $newLink->save();
    }
  }
  
  
  public function actionProduct()
  {
    $products = $this->queryAll('SELECT * FROM `Mod_PayProduct` ORDER BY `ProductId` ASC');
    foreach ($products as $product)
    {
      $newProduct = new \pay\models\Product();
      $newProduct->Id = $product['ProductId'];
      $newProduct->ManagerName = $product['Manager'];
      $newProduct->Title = $product['Title'];
      if (!empty($product['Description']))
      {
        $newProduct->Description = $product['Description'];
      }
      $newProduct->EventId = $product['EventId'];
      if (!empty($product['Unit']))
      {
        $newProduct->Unit = $product['Unit'];
      }
      if (!empty($product['Count']))
      {
        $newProduct->Count = $product['Count'];
      }
      $newProduct->EnableCoupon = $product['EnableCoupon'] == 1 ? true : false;
      $newProduct->save();
    }
  }
  
  public function actionProductattr()
  {
    $attributes = $this->queryAll('SELECT * FROM `Mod_PayProductAttribute` ORDER BY `ProductAttributeId` ASC');
    foreach ($attributes as $attr)
    {
      $newAttr = new \pay\models\ProductAttribute();
      $newAttr->Id = $attr['ProductAttributeId'];
      $newAttr->ProductId = $attr['ProductId'];
      $newAttr->Name = $attr['Name'];
      $newAttr->Value = $attr['Value'];
      $newAttr->save();
    }
  }
  
  public function actionProductprice()
  {
    $prices = $this->queryAll('SELECT * FROM `Mod_PayProductPrice` ORDER BY `ProductPriceId` ASC');
    foreach ($prices as $price)
    {
      $newPrice = new \pay\models\ProductPrice();
      $newPrice->Id = $price['ProductPriceId'];
      $newPrice->ProductId = $price['ProductId'];
      $newPrice->Price = $price['Price'];
      $newPrice->StartTime = $price['StartTime'];
      if (!empty($price['EndTime']))
      {
        $newPrice->EndTime = $price['EndTime'];
      }
      $newPrice->save();
    }
  }
}

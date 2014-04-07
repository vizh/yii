<?php
namespace pay\controllers\admin\booking;

class ProductAction extends \CAction
{
  public $excludedAttributeNames = ['Price','AdditionalPrice'];

  public function run($productId, $backUrl = null)
  {
    $product = \pay\models\Product::model()->byManagerName('RoomProductManager')->byEventId(\BookingController::EventId)->findByPk($productId);
    if ($product == null)
      throw new \CHttpException(404);

    $form = new \pay\models\forms\admin\BookingProduct();
    foreach ($product->getManager()->getProductAttributeNames() as $name)
    {
      if (in_array($name, $this->excludedAttributeNames))
        continue;

      $form->Attributes[$name] = $product->getManager()->$name;
    }

    $request = \Yii::app()->getRequest();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      foreach ($form->Attributes as $name => $value)
      {
        if (in_array($name, $this->excludedAttributeNames))
          continue;

        $product->getManager()->$name = $value;
      }
      \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Настройки продукта успешно сохранены!'));
      $this->getController()->refresh();
    }

    $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование товара с номером.'));
    $this->getController()->render('product', ['form' => $form, 'product' => $product, 'backUrl' => $backUrl]);
  }
} 
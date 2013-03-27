<?php
namespace partner\models\forms;

class CouponGenerate extends \CFormModel
{
  public $count;
  public $discount;
  public $productId;

  /** @var \pay\models\Product */
  public $product;

  /** @var \event\models\Event */
  public $event = null;

  public function rules()
  {
    return array(
      array('count, discount, productId', 'safe')
    );
  }

  protected function afterValidate()
  {
    parent::afterValidate();
    $this->count = (int) $this->count;
    $this->discount = (int) $this->discount;
    $this->productId = (int) $this->productId;

    if ($this->event === null)
    {
      $this->addError('event', 'Для валидации формы необходимо задать мероприятие');
      return;
    }

    if ($this->count <= 0)
    {
      $this->addError('count', 'Значение поля "' . $this->getAttributeLabel('count') . '" должно быть целым числом больше нуля');
    }
    if ($this->discount <= 0 || $this->discount > 100)
    {
      $this->addError('discount', 'Значение поля "' . $this->getAttributeLabel('discount') . '" должно быть целым числом от 1 до 100');
    }

    if ($this->discount === 100 || $this->productId !== 0)
    {
      $this->product = \pay\models\Product::model()->findByPk($this->productId);
      if ($this->product === null || $this->product->EventId != $this->event->Id)
      {
        $this->addError('productId', 'Не корректно задано поле "' . $this->getAttributeLabel('productId') . '"');
        return;
      }
    }
  }


  public function attributeLabels()
  {
    return array(
      'count' => 'Количество промо-кодов',
      'discount' => 'Размер скидки (%)',
      'productId' => 'Тип продукта'
    );
  }
}

<?php
namespace partner\models\forms\coupon;

class Generate extends \CFormModel
{
  public $type = 'solo';
  public $count;
  public $discount;
  public $productId;
  public $endTime;

  public $suffix;

  /** @var \pay\models\Product */
  public $product;

  /** @var \event\models\Event */
  public $event = null;

  public function rules()
  {
    return [
      ['type, productId, suffix', 'safe'],
      ['discount', 'numerical', 'min' => 1, 'max' => 100, 'integerOnly' => true, 'allowEmpty' => false],
      ['count', 'numerical', 'min' => 1, 'integerOnly' => true, 'allowEmpty' => false],
      ['endTime', 'date', 'allowEmpty' => true, 'format' => 'dd.MM.yyyy'],

      /** Валидация для сценария many */
      ['suffix', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/', 'allowEmpty' => false, 'on' => 'many', 'message' => 'Поле "Промо-код" должно содержать латиницу и цифры'],
    ];
  }

  public function getTypes()
  {
    return [
      'solo' => 'Индивидуальный',
      'many' => 'Множественный',
    ];
  }

  protected function afterValidate()
  {
    parent::afterValidate();
    $this->discount = (int)$this->discount;
    $this->productId = (int)$this->productId;

    $this->product = \pay\models\Product::model()->findByPk($this->productId);
    if ($this->product !== null && $this->product->EventId != $this->event->Id)
    {
      $this->addError('productId', 'Не корректно задано поле "' . $this->getAttributeLabel('productId') . '"');
    }

    if ($this->discount === 100 && $this->product == null)
    {
      $this->addError('productId', 'Для 100% промо-кодов необходимо заполнить поле "' . $this->getAttributeLabel('productId') . '"');
    }


    if (\pay\models\Coupon::model()->byCode($this->getFullCode())->exists())
    {
      $this->addError('suffix', 'Такой промо-код уже существует.');
    }
  }

  /**
   * @return \pay\models\Coupon[] $coupon
   */
  public function generate()
  {
    $result = [];
    $endTime = !empty($this->endTime) ? date('Y-m-d', strtotime($this->endTime)) . ' 23:59:59' : null;
    if ($this->type == 'many')
    {
      $coupon = new \pay\models\Coupon();
      $coupon->EventId = $this->event->Id;
      $coupon->Discount = (float) $this->discount / 100;
      $coupon->ProductId = $this->product !== null ? $this->product->Id : null;
      $coupon->Code = $this->getFullCode();
      $coupon->Multiple = true;
      $coupon->MultipleCount = $this->count;
      $coupon->EndTime = $endTime;
      $coupon->save();

      $result[] = $coupon;
    }
    else
    {
      for ($i=0; $i<$this->count; $i++)
      {
        $coupon = new \pay\models\Coupon();
        $coupon->EventId = $this->event->Id;
        $coupon->Discount = (float) $this->discount / 100;
        $coupon->ProductId = $this->product !== null ? $this->product->Id : null;
        $coupon->Code = $coupon->generateCode();
        $coupon->EndTime = $endTime;
        $coupon->save();

        $result[] = $coupon;
      }
    }

    return $result;
  }


  public function attributeLabels()
  {
    return [
      'suffix' => 'Промо-код',
      'count' => $this->getCountTitle(),
      'discount' => 'Размер скидки (%)',
      'productId' => 'Тип продукта',
      'endTime' => 'Срок действия до'
    ];
  }

  protected function getCountTitle()
  {
    if ($this->scenario == 'many')
    {
      return 'Количество активаций промо-кодa';
    }
    return 'Количество промо-кодов';
  }

  public function getFullCode()
  {
    return strtoupper($this->event->IdName . '_' . $this->suffix);
  }
}

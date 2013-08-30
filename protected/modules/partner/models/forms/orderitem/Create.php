<?php
namespace partner\models\forms\orderitem;

class Create extends \CFormModel
{
  public $ProductId;
  public $PayerRunetId;
  public $OwnerRunetId;

  public $OrderItem;

  /** @var \event\models\Event */
  protected $event;

  /**
   * @param \event\models\Event $event
   * @param string $scenario
   */
  public function __construct($event, $scenario = '')
  {
    parent::__construct($scenario);
    $this->event = $event;
  }

  public function rules()
  {
    return [
      ['PayerRunetId, OwnerRunetId, ProductId', 'required'],
      ['PayerRunetId, OwnerRunetId', 'userExist'],
      ['ProductId', 'productExist']
    ];
  }

  public function userExist($attribute, $params)
  {
    if (!\user\models\User::model()->byRunetId($this->$attribute)->exists())
    {
      $this->addError($attribute, 'Не найден пользователь поля '.$this->getAttributeLabel($attribute));
    }
  }

  protected $product = null;

  public function getProduct()
  {
    if ($this->product === null)
    {
      $this->product = \pay\models\Product::model()->findByPk($this->ProductId);
    }
    return $this->product;
  }

  public function productExist($attribute, $params)
  {
    if ($attribute == 'ProductId' && $this->getProduct() == null)
    {
      $this->addError($attribute, 'Не найден выбранный товар');
    }
  }

  protected $products = null;

  public function getProducts()
  {
    if ($this->products === null)
    {
      $this->products = \pay\models\Product::model()
          ->byEventId($this->event->Id)->findAll(['order' => '"t"."Priority" DESC']);
    }
    return $this->products;
  }

  protected $productData = null;

  public function getProductData()
  {
    if ($this->productData === null)
    {
      $this->productData = ['' => 'Выберите товар'];
      foreach ($this->getProducts() as $product)
      {
        $this->productData[$product->Id] = $product->Title;
      }
    }
    return $this->productData;
  }

  public function attributeLabels()
  {
    return array(
      'ProductId' => \Yii::t('app', 'Товар'),
      'PayerRunetId' => \Yii::t('app', 'Плательщик'),
      'OwnerRunetId' => \Yii::t('app', 'Получатель'),
    );
  }
}
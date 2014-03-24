<?php
namespace pay\models\forms;

class Product extends \CFormModel
{
  private $product;
  private $event;
  
  public $Id;
  public $Title;
  public $Public;
  public $Priority;
  public $Description;
  public $EnableCoupon;
  public $Unit;
  public $ManagerName;
  public $Attributes = [];
  public $Prices = [];
  public $AdditionalAttributes = [];
  public $Delete;

  public function __construct(\event\models\Event $event, \pay\models\Product $product = null, $scenario = '')
  {
    parent::__construct($scenario);
    $this->event = $event;
    if ($product !== null)
    {
      foreach ($product->getAttributes() as $attr => $value)
      {
        if ($attr == 'AdditionalAttributes')
          continue;

        if (in_array($attr, $this->attributeNames()))
          $this->$attr = $value;
      }
      $this->product = $product;
    }
  }
  
  public function setAttributes($values, $safeOnly = true)
  {
    if (isset($values['Prices']))
    {
      foreach ($values['Prices'] as $value)
      {
        $form = new \pay\models\forms\ProductPrice();
        $form->attributes = $value;
        $this->Prices[] = $form;
      }
      unset($values['Prices']);
    }

    if (isset($values['AdditionalAttributes']))
    {
      foreach($values['AdditionalAttributes'] as $value)
      {
        $form = new \pay\models\forms\AdditionalAttribute();
        $form->attributes = $value;
        $this->AdditionalAttributes[] = $form;
      }
      unset($values['AdditionalAttributes']);
    }

    if (!empty($values['Id']))
    {
      $this->product = \pay\models\Product::model()->findByPk($values['Id']);
    }
    parent::setAttributes($values, $safeOnly);
  }
  
  public function filterAttributes($attributes)
  {
    if (!empty($this->product))
    {
      $manager = $this->getProduct()->getManager();
      foreach ($manager->getProductAttributeNames() as $name)
      {
        if (!isset($attributes[$name]) || empty($attributes[$name]))
          $this->addError('Attributes', \Yii::t('app', 'Не указан атрибут обязательный товара').' '.$name);
      }
    }
    return $attributes;
  }

  public function filterPrices($prices)
  {
    $valid = true;
    foreach ($prices as $price)
    {
      if (!$price->validate())
      {
        $valid = false;
      }
    }
    if (!$valid)
    {
      $this->addError('Prices', \Yii::t('app', 'Ошибка в заполнении цен'));
    }
    else
    {
      $lastEndDate = new \DateTime();
      foreach ($prices as $i => $price)
      {
        $curStartDate = new \DateTime($price->StartDate);
        if ((empty($price->EndDate) && isset($prices[$i+1]))
          || ($i != 0 && $curStartDate->modify('-1 day') != $lastEndDate))
        {
          $this->addError('Prices', \Yii::t('app', 'Нарушена непрерывность цен'));
          break;
        }
        $lastEndDate->setTimestamp(strtotime($price->EndDate));
      }
    }
    return $prices;
  }

  public function clearPrices()
  {
    foreach ($this->Prices as $i => $formPrice)
    {
      if (!empty($formPrice->Delete))
      {
        if (!empty($formPrice->Id))
        {
          $price = \pay\models\ProductPrice::model()->findByPk($this->Prices[$i]->Id);
          if ($price !== null && $price->ProductId == $this->getProduct()->Id)
            $price->delete();
        }
        unset($this->Prices[$i]);
      }
    }
  }


  public function getProduct()
  {
    return $this->product;
  }
  
  public function getManagerData()
  {
    $managers = [];
    if (!empty($this->event->Parts))
    {
      $managers = [
        'EventOnPart' => \Yii::t('app', 'Часть мероприятия'),
        'EventListParts' => \Yii::t('app', 'Несколько частей мероприятия'),
        'EventAllParts' => \Yii::t('app', 'Все части мероприятия')
      ];
    }
    else
    {
      $managers = [
        'EventProductManager' => \Yii::t('app', 'Мероприятие'),
        'EventMicrosoft' =>  \Yii::t('app', 'Тип товара для мероприятий Microsoft'),
      ];
    }
    $managers['FoodProductManager'] = \Yii::t('app', 'Питание');
    $managers['Ticket'] = \Yii::t('app', 'Билет');
    return $managers;
  }
  
  public function getManagerTitle()
  {
    return $this->getManagerData()[$this->ManagerName];
  }


  public function getPriorityData()
  {
    $result = [];
    for ($i = 0; $i <= 100; $i++)
      $result[] = $i;
    
    return $result;
  }
  
  public function rules()
  {
    return [
      ['Id,Public,Priority,EnableCoupon,Delete', 'safe'],
      ['Title,ManagerName,Unit', 'required'],
      ['Description', 'filter', 'filter' => [$this, 'filterDescription']],
      ['Prices', 'filter', 'filter' => array($this, 'filterPrices')],
      ['Attributes', 'filter', 'filter' => array($this, 'filterAttributes')],
      ['AdditionalAttributes', 'filter', 'filter' => [$this, 'filterAdditionalAttributes']]
    ];
  }

  public function filterAdditionalAttributes($attributes)
  {
    $valid = true;
    foreach ($attributes as $attr)
    {
      if (!$attr->validate())
      {
        $valid = false;
      }
    }
    if (!$valid)
    {
      $this->addError('Prices', \Yii::t('app', 'Ошибка в заполнении дополнительных параметров заказа'));
    }
    return $attributes;
  }

  public function filterDescription($value)
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = [
      'HTML.AllowedElements'   => ['p', 'ul', 'li'],
      'HTML.AllowedAttributes' => ['class'],
    ];
    return trim($purifier->purify($value));
  }

  public function attributeLabels()
  {
    return [
      'Title' => \Yii::t('app', 'Название'),
      'Description' => \Yii::t('app', 'Описание'),
      'Public' => \Yii::t('app', 'Отображение'),
      'Priority' => \Yii::t('app', 'Приоритет'),
      'ManagerName' => \Yii::t('app', 'Менеджер'),
      'Attributes' => \Yii::t('app', 'Параметры'),
      'Prices' => \Yii::t('app', 'Цены'),
      'Unit' => \Yii::t('app', 'Ед. измерения'),
      'EnableCoupon' => \Yii::t('app', 'Разрешить промо-коды'),
      'AdditionalAttributes' => \Yii::t('app', 'Дополнительные параметры заказа')
    ];
  }
}

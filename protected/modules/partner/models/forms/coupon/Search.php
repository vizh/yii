<?php
namespace partner\models\forms\coupon;


class Search extends \CFormModel
{
  public $Code;
  public $Owner = '';
  public $Activator;
  public $Discount;
  public $Activated;
  public $Product;

  public function rules()
  {
    return array(
      array('Code, Owner, Discount, Activator, Activated, Product, Owner', 'safe')
    );
  }

  /**
   * @return \CDbCriteria
   */
  public function getCriteria()
  {
    $criteria = new \CDbCriteria();

    if ($this->Code != '')
    {
      $criteria->addCondition('"t"."Code" = :Code');
      $criteria->params['Code'] = $this->Code;
    }

    if ((int)$this->Activator !== 0)
    {
      $user = \user\models\User::model()->byRunetId($this->Activator)->find();
      if ($user !== null)
      {
        $criteria->addCondition('"Activations"."UserId" = :UserId');
        $criteria->params['UserId'] = $user->Id;
        $criteria->with['Activations'] = array('together' => true);
      }
    }

    if ((int)$this->Discount !== 0)
    {
      $criteria->addCondition('"t"."Discount" = :Discount');
      $criteria->params['Discount'] = number_format((float)$this->Discount/100, 2);
    }

    if ($this->Activated !== '' && $this->Activated !== null)
    {
      if ($this->Activated == 1)
      {
        $criteria->addCondition('"Activations"."Id" IS NOT NULL');
      }
      else
      {
        $criteria->addCondition('"Activations"."Id" IS NULL');
      }
      $criteria->with['Activations'] = array('together' => true);
    }

    if ((int)$this->Product !== 0)
    {
        $criteria->with['ProductLinks'] = ['together' => true, 'select' => false];
      $criteria->addCondition('"ProductLinks"."ProductId" = :ProductId');
      $criteria->params['ProductId'] = $this->Product;
    }

    if (!empty($this->Owner))
    {
      $userModel = new \user\models\User();
      if (strpos($this->Owner, '@') !== false)
      {
        $userModel->byEmail($this->Owner);
      }
      else
      {
        $userModel->bySearch($this->Owner, null, true, false);
      }
      $user = $userModel->find();
      if ($user !== null)
      {
        $criteria->addCondition('"OwnerId" = :OwnerId');
        $criteria->params['OwnerId'] = $user->Id;
      }
      else
      {
        $criteria->addCondition('1=2');
      }
    }

    return $criteria;
  }

  public function attributeLabels()
  {
    return [
      'Code' => 'Промо-код',
      'Activator' => 'Получатель',
      'Discount' => 'Размер скидки (%)',
      'Activated' => 'Активирован',
      'Product' => 'Товар',
      'Owner' => 'Владелец билета'
    ];
  }

  public function getListValues()
  {
    return [
      '' => '',
      1 => 'Да',
      0 => 'Нет',
    ];
  }
}
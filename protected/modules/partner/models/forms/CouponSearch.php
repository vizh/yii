<?php
namespace partner\models\forms;


class CouponSearch extends \CFormModel
{
  public $Code;
  public $Owner;
  public $Discount;
  public $Activated;
  public $Product;

  public function rules()
  {
    return array(
      array('Code, Owner, Discount, Activated, Product', 'safe')
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

    if ((int)$this->Owner !== 0)
    {
      $user = \user\models\User::model()->byRunetId($this->Owner)->find();
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
      $criteria->addCondition('"t"."ProductId" = :ProductId');
      $criteria->params['ProductId'] = $this->Product;
    }

    return $criteria;
  }

  public function attributeLabels()
  {
    return array(
      'Code' => 'Промо-код',
      'Owner' => 'Получатель',
      'Discount' => 'Размер скидки (%)',
      'Activated' => 'Активирован',
      'Product' => 'Товар'
    );
  }

  public function getListValues()
  {
    return array(
      '' => '',
      1 => 'Да',
      0 => 'Нет',
    );
  }
}
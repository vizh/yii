<?php
namespace pay\models;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Recipient
 * @property string $Address
 * @property int $INN
 * @property int $KPP
 * @property string $Bank
 * @property int $BankAccountNumber
 * @property int $AccountNumber
 * @property int $BIK
 * @property string $Phone
 * @property string $Fax
 * @property string $SignFirstTitle
 * @property string $SignFirstName
 * @property int[]  $SignFirstImageMargin
 * @property string $SignSecondTitle
 * @property string $SignSecondName
 * @property int[]  $SignSecondImageMargin
 * @property int[]  $StampImageMargin
 * @property bool $VAT
 *
 */
class OrderJuridicalTemplate extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayOrderJuridicalTemplate';
  }

  public function primaryKey()
  {
    return 'Id';
  }
  
  protected function afterFind()
  {
    $this->SignFirstImageMargin  = explode(',', trim($this->SignFirstImageMargin,')('));  
    $this->SignSecondImageMargin = explode(',', trim($this->SignSecondImageMargin,')('));  
    $this->StampImageMargin      = explode(',', trim($this->StampImageMargin,')('));
    parent::afterFind();
  }
  
  protected function afterSave()
  {
    if ($this->getIsNewRecord())
    {
      mkdir(\Yii::getPathOfAlias('webroot.img.pay.bill.template').DIRECTORY_SEPARATOR.$this->Id.DIRECTORY_SEPARATOR);
    }
    parent::afterSave();
  }


  public function getFirstSignImagePath($absolute = false)
  {
    return $this->getImagePath('fist-sign.png', $absolute);
  }
  
  public function getSecondSignImagePath($absolute = false)
  {
    return $this->getImagePath('secong-sign.png', $absolute);
  }
  
  public function getStampImagePath($absolute = false)
  {
    return $this->getImagePath('stamp.png', $absolute);
  }
  
  private function getImagePath($name, $absolute = false)
  {
    return ($absolute ? \Yii::getPathOfAlias('webroot') : '').'/img/pay/bill/template/'.$this->Id.'/'.$name;
  }
}
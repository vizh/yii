<?php
namespace pay\models;

/**
 * @property int $OrderJuridicalId
 * @property int $OrderId
 * @property string $Name
 * @property string $Address
 * @property string $INN
 * @property string $KPP
 * @property string $Phone
 * @property string $Fax
 * @property string $PostAddress
 * @property int $Paid
 * @property int $Deleted
 *
 * @property Order $Order
 */
class OrderJuridical extends \CActiveRecord
{
  public static $TableName = 'Mod_PayOrderJuridical';

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'OrderJuridicalId';
  }

  public function relations()
  {
    return array(
      'Order' => array(self::BELONGS_TO, 'Order', 'OrderId'),
    );
  }

  private static $SecretKey = '7deSAJ42VhzHRgYkNmxz';
  public function GetHash()
  {
    return substr(md5($this->OrderId.self::$SecretKey), 0, 16);
  }

  public function CheckHash($hash)
  {
    return $hash == $this->GetHash();
  }

  public function DeleteOrder()
  {
    if ($this->Deleted == 1 || $this->Paid == 1)
    {
      return;
    }
    foreach ($this->Order->Items as $item)
    {
      if ($item->Booked != null)
      {
        $item->Booked = date('Y-m-d H:i:s', time() + 3 * 60 * 60);
      }
      $item->PaidTime = null;
      $item->save();
    }
    $this->Deleted = 1;
    $this->save();
  }
}
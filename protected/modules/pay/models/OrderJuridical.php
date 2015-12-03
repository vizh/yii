<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $OrderId
 * @property string $Name
 * @property string $Address
 * @property string $INN
 * @property string $KPP
 * @property string $Phone
 * @property string $Fax
 * @property string $PostAddress
 * @property string $ExternalKey
 * @property string $UrlPay
 *
 * @property Order $Order
 */
class OrderJuridical extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayOrderJuridical';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Order' => array(self::BELONGS_TO, '\pay\models\Order', 'OrderId'),
    );
  }

}
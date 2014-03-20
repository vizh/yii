<?php
namespace pay\models\forms\admin;

class PartnerBooking extends \CFormModel
{
  public $Id;
  public $Owner;
  public $DateIn;
  public $DateOut;
  public $AdditionalCount;
  public $Paid;

  private $product;

  public function __construct(\pay\models\Product $product, $scenario='')
  {
    $this->product = $product;
  }

  public function rules()
  {
    return [
      ['Owner, DateIn, DateOut', 'required'],
      ['DateIn, DateOut', 'date', 'allowEmpty' => false, 'format' => 'yyyy-MM-dd'],
      ['Paid', 'safe'],
      ['AdditionalCount', 'checkAdditional']
    ];
  }

  public function checkAdditional($attribute)
  {
    /** @var \pay\components\managers\RoomProductManager $manager */
    $manager = $this->product->getManager();
    if ($manager->PlaceMore < $this->AdditionalCount)
    {
      $this->addError('AdditionalCount', 'Количество выбранных доп. мест превышает максимально допустимое для данного номера. Максимум: ' .$manager->PlaceMore);
    }
  }


  public function attributeLabels()
  {
    return [
      'Owner' => 'Название',
      'DateIn' => 'Дата заезда',
      'DateOut' => 'Дата выезда',
      'AdditionalCount' => 'Количество доп. мест'
    ];
  }

} 
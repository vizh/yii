<?php
namespace pay\models\forms\admin;

class BookingSearch extends \CFormModel
{
  private $groups = ['Hotel', 'Housing', 'Category', 'DescriptionBasic', 'DescriptionMore', 'PlaceBasic', 'PlaceMore', 'PlaceTotal', 'RoomCount'];

  private $groupValues = [];

  public $Hotel;
  public $Housing;
  public $Category;
  public $DescriptionBasic;
  public $DescriptionMore;
  public $PlaceBasic;
  public $PlaceMore;
  public $PlaceTotal;
  public $RoomCount;

  public function init()
  {
    parent::init();

    $results = \Yii::app()->getDb()->createCommand()
      ->select('ppa.Name, ppa.Value')->from('PayProductAttribute ppa')
      ->leftJoin('PayProduct pp', 'ppa."ProductId" = pp."Id"')
      ->where('pp."EventId" = :EventId AND pp."ManagerName" = :ManagerName')
      ->andWhere('ppa."Name" IN (\'' . implode('\',\'', $this->groups) . '\')')
      ->group('ppa.Name, ppa.Value')
      ->query(['EventId' => \BookingController::EventId, 'ManagerName' => 'RoomProductManager']);

    foreach ($results as $row)
    {
      $name = $row['Name'];
      if (!isset($this->groupValues[$name]))
        $this->groupValues[$name] = [];
      $this->groupValues[$name][] = $row['Value'];
    }
    print_r($this->groupValues);
  }

  public function rules()
  {
    return [];
  }

  public function attributeLabels()
  {
    return [
      '' => '',
    ];
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 26.06.14
 * Time: 12:28
 */

namespace pay\models\forms;


class LoyaltyProgramDiscount extends \CFormModel
{
  private $event;

  public $ProductId;
  public $Discount;
  public $StartDate;
  public $EndDate;

  public function __construct(\event\models\Event $event, $scenario = '')
  {
    $this->event = $event;
    parent::__construct($scenario);
  }


  public function rules()
	{
    return [
      ['Discount', 'required'],
      ['ProductId', 'exist', 'className' => '\pay\models\Product', 'attributeName' => 'Id', 'criteria' => ['condition' => '"t"."EventId" = :EventId', 'params' => ['EventId' => $this->event->Id]], 'allowEmpty' => true],
      ['Discount', 'numerical', 'min' => 1, 'max' => 100, 'integerOnly' => true],
      ['StartDate, EndDate', 'date', 'format' => 'dd.MM.yyyy', 'allowEmpty' => true],
      ['StartDate', 'filter', 'filter' => [$this, 'filterDate']]
    ];
  }

  public function attributeLabels()
  {
    return [
      'Discount' => \Yii::t('app', 'Размер скидки'),
      'ProductId' => \Yii::t('app', 'Товар'),
      'StartDate' => \Yii::t('app', 'Дата начала'),
      'EndDate' => \Yii::t('app', 'Дата окончания')
    ];
  }


  public function filterDate($value)
  {
    if (!$this->hasErrors('StartDate') && !$this->hasErrors('EndDate'))
    {
      $criteria = new \CDbCriteria();
      $criteria->addCondition('"t"."EventId" = :EventId');
      $criteria->params['EventId'] = $this->event->Id;
      if (!empty($this->ProductId))
      {
        $criteria->addCondition('"t"."ProductId" IS NULL OR "t"."ProductId" = :ProductId');
        $criteria->params['ProductId'] = $this->ProductId;
      }

      $starttime = !empty($this->StartDate) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd 00:00:00', $this->StartDate) : null;
      $endtime = !empty($this->EndDate) ? \Yii::app()->getDateFormatter()->format('yyyy-MM-dd 23:59:59', $this->EndDate) : null;

      if ($starttime !== null && $endtime !== null && $endtime < $starttime)
      {
        $this->addError('EndDate', \Yii::t('app', 'Дата окончания должна быть больше даты начала.'));
      }

      if ($starttime !== null || $endtime !== null)
      {
        $criteria->addCondition(
          '(("t"."StartTime" IS NULL OR "t"."StartTime" <= :Time1) AND ("t"."EndTime" IS NULL OR "t"."EndTime" >= :Time2)) OR ("t"."StartTime" >= :Time1 AND "t"."EndTime" <= :Time2)'
        );
        $criteria->params['Time1'] = $starttime !== null ? $starttime : $endtime;
        $criteria->params['Time2'] = $endtime !== null ? $endtime : $starttime;
      }
      if (\pay\models\LoyaltyProgramDiscount::model()->exists($criteria))
      {
        $this->addError('StartDate', \Yii::t('app', 'Даты действия скидки пересекается с другими скидками.'));
      }
    }
    return $value;
  }

  public function getProductData()
  {
    $data = ['' => \Yii::t('app', 'Все продукты')];
    $products = \pay\models\Product::model()->byEventId($this->event->Id)->byPublic(true)->findAll();
    foreach ($products as $product)
    {
      $data[$product->Id] = $product->Title;
    }
    return $data;
  }
}
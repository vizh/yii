<?php
namespace partner\models\forms\program;

class Hall extends \CFormModel
{
  public $Id;
  public $Title;
  public $Order = 0;
  public $Delete = 0;

  private $event;

  public function __construct(\event\models\Event $event, $scenario = '')
  {
    parent::__construct($scenario);
    $this->event = $event;
  }

  public function rules()
  {
    return [
      ['Id', 'exist', 'className' => '\event\models\section\Hall', 'attributeName' => 'Id', 'criteria' => ['condition' => '"t"."EventId" = :EventId', 'params' => ['EventId' => $this->event->Id]], 'allowEmpty' => true],
      ['Title', 'required'],
      ['Order', 'numerical'],
      ['Delete', 'boolean', 'allowEmpty' => true]
    ];
  }

  public function attributeLabels()
  {
    return [
      'Title' => \Yii::t('app', 'Название зала'),
      'Order' => \Yii::t('app', 'Сортировка')
    ];
  }


} 
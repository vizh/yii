<?php
namespace event\models\forms\widgets;

class Base extends \CFormModel
{
  public $Attributes = [];

  public function rules()
  {
    return [
      ['Attributes', 'filter', 'filter' => [$this, 'filterAttributes']]
    ];
  }

  public function filterAttributes($value)
  {
    if (!is_array($value))
      $this->addError('Attributes', \Yii::t('app', 'Не заполнены параметры виджета!'));

    $textUtility = new \application\components\utility\Texts();
    foreach ($value as $key => $val)
    {
      $value[$key] = $textUtility->filterPurify($val);
    }
    return $value;
  }
} 
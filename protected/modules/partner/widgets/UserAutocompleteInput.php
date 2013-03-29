<?php
namespace partner\widgets;
class UserAutocompleteInput extends \CWidget
{
  public $form = null;
  public $field; 
  public $value;
  public $htmlOptions = array();
  
  public function init()
  {
    if ($this->form !== null)
    {    
      $this->value = $this->form->{$this->field};
      $this->field = \CHtml::resolveName($this->form, $this->field);
    }
    else
    {
      $this->value = $this->getValue($this->field);
    }
  }


  public function run() 
  {
    $cs = \Yii::app()->clientScript;
    \Yii::app()->clientScript->registerPackage('runetid.jquery.ui');
    $cs->registerScriptFile(
      \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('partner.widgets.assets.js').'/userautocompleteinput.js'), \CClientScript::POS_HEAD
    );
    
    if (!empty($this->value))
    {
      $user = \user\models\User::model()->byRunetId($this->value)->find();
    }
    
    $htmlOptions = '';
    if (!empty($this->htmlOptions))
    {
      foreach ($this->htmlOptions as $option => $value) 
      {
        $htmlOptions .= $option.'="'.$value.'"';
      }
    }
    
    $this->render('userAutocompleteInput', array(
      'user'  => $user,
      'field' => $this->field,
      'value' => $this->value,
      'htmlOptions' => $htmlOptions
    ));
  }
  
  private function getValue($fieldName)
  {
    $request = \Yii::app()->getRequest();
    if (strpos($fieldName, ']'))
    {
      $keys = preg_split('/[\s]*[\]\[]/', $fieldName, null, PREG_SPLIT_NO_EMPTY);
      $value = $request->getParam(array_shift($keys), '');
      if (!empty($value))
      {
        foreach ($keys as $key)
        {
          $value = $value[$key];
        }
      }
    }
    else {
      $value = $request->getParam($fieldName, '');
    }
    return $value;
  }
}

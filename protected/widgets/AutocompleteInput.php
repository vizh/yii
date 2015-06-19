<?php
namespace application\widgets;

class AutocompleteInput extends \CWidget
{
  public $form = null;
  public $field;
  public $value;
  public $htmlOptions = [];
  public $addOn = null;
  public $source;
  public $class = null;
  public $adminMode = false;


  public function init()
  {
    $this->initResources();
    if ($this->form !== null)
    {
      $this->value = \CHtml::resolveValue($this->form, $this->field);
      $this->field = \CHtml::resolveName($this->form, $this->field);
    }
    else
    {
      $this->value = $this->getValue($this->field);
    }
    $this->htmlOptions['data-autocompleteinput'] = 1;
    $this->htmlOptions['data-source'] = $this->source;
    $this->htmlOptions['data-add-on'] = $this->addOn;
    if (!isset($this->htmlOptions['id']))
    {
      $this->htmlOptions['id'] = false;
    }
  }

  public function run()
  {
    $this->render('autocompleteInput');
  }

  protected function initResources()
  {
    $cs = \Yii::app()->getClientScript();
    if (!$this->adminMode)
    {
      $cs->registerPackage('runetid.jquery.ui');
    }
    else
    {
      $cs->registerPackage('runetid.admin.jquery.ui');
    }

    $cs->registerScriptFile(
      \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('application.widgets.assets.js').'/autocompleteinput.js'),
      \CClientScript::POS_HEAD
    );
  }

  /**
   * @return string
   */
  public function getData()
  {
    $model = null;
    if (!empty($this->value) && $this->class !== null)
    {
      $class = $this->class;
      /** @var IAutocompleteItem $model */
      $model = $class::model()->byAutocompleteValue($this->value)->find();
    }
    return $model !== null ? $model->getAutocompleteData() : $this->value;
  }

  protected function getValue($fieldName)
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
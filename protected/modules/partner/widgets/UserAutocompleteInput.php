<?php
namespace partner\widgets;

use user\models\User;

class UserAutocompleteInput extends \CWidget
{
    public $form;

    public $attribute;

    public $field;

    public $value;

    public $htmlOptions = ['class' => 'form-control'];

    public $help;

    /**
     *
     */
    public function init()
    {
        if ($this->form !== null) {
            $this->value = \CHtml::resolveValue($this->form, $this->attribute);
            $this->field = \CHtml::resolveName($this->form, $this->attribute);
        } else {
            $this->value = $this->getValue($this->field);
        }
        $this->registerResources();
    }

    /**
     * @throws \CException
     */
    public function run()
    {
        $user = null;
        if (!empty($this->value)) {
            $user = User::model()->byRunetId($this->value)->find();
        }

        $this->htmlOptions['data-userautocompleteinput'] = 1;
        $this->htmlOptions['data-eventid'] = \CHtml::value(\Yii::app()->partner->getEvent(), 'Id');
        $this->render('user-input', ['user' => $user]);
    }

    /**
     * @param $fieldName
     * @return mixed
     */
    private function getValue($fieldName)
    {
        $request = \Yii::app()->getRequest();
        if (strpos($fieldName, ']')) {
            $keys = preg_split('/[\s]*[\]\[]/', $fieldName, null, PREG_SPLIT_NO_EMPTY);
            $value = $request->getParam(array_shift($keys), '');
            if (!empty($value)) {
                foreach ($keys as $key) {
                    $value = $value[$key];
                }
            }
        } else {
            $value = $request->getParam($fieldName, '');
        }
        return $value;
    }

    /**
     * @throws \CException
     */
    private function registerResources()
    {
        $clientScript = \Yii::app()->clientScript;
        $clientScript->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('partner.widgets.assets.js').'/userinput.js'), \CClientScript::POS_HEAD
        );
    }
}

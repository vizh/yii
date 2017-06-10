<?php
namespace application\widgets;

use application\components\form\FormModel;
use application\components\traits\ClassNameTrait;

class ActiveForm extends \CActiveForm
{
    use ClassNameTrait;

    /**
     * @var FormModel|null
     */
    public $scrollIfHasErrors;

    /**
     * @inheritdoc
     **/
    public function errorSummary($models, $header = '<div class="alert alert-danger">', $footer = '</div>', $htmlOptions = [])
    {
        return parent::errorSummary($models, $header, $footer, $htmlOptions);
    }

    /**
     * Runs the widget.
     * This registers the necessary javascript code and renders the form close tag.
     */
    public function run()
    {
        $cs = \Yii::app()->getClientScript();
        if ($this->scrollIfHasErrors !== null && $this->scrollIfHasErrors->hasErrors()) {
            $cs->registerScript('CActiveForm#scrollhasErrors', "
                 window.location.hash = '#$this->id';
            ", \CClientScript::POS_READY);
        }
        return parent::run();
    }

    /**
     * @param FormModel $model
     * @param $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function help(FormModel $model, $attribute, $htmlOptions = [])
    {
        $message = $model->getAttributeHelpMessage($attribute);
        if ($message === null) {
            return '';
        }

        if (!isset($htmlOptions['class'])) {
            $htmlOptions['class'] = 'help-block';
        }

        return \CHtml::tag('span', $htmlOptions, $message);
    }

    /**
     * @param FormModel $model
     * @param string $attribute
     * @param sting $label
     * @param array $htmlOptions
     * @return string
     */
    public function button(FormModel $model, $attribute, $label, $htmlOptions = [])
    {
        $htmlOptions['name'] = \CHtml::activeName($model, $attribute);
        return \CHtml::tag('button', $htmlOptions, $label);
    }

    /**
     * @param FormModel $model
     * @param string $attribute
     * @param string $label
     * @param array $htmlOptions
     * @return string
     */
    public function submitButton(FormModel $model, $attribute, $label, $htmlOptions = [])
    {
        $htmlOptions['type'] = 'submit';
        return $this->button($model, $attribute, $label, $htmlOptions);
    }
}
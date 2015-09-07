<?php
/**
 * Created by PhpStorm.
 * User: ������
 * Date: 05.08.2015
 * Time: 13:06
 */

namespace application\widgets;

use application\components\form\FormModel;

class ActiveForm extends \CActiveForm
{
    /**
     * @inheritdoc
     **/
    public function errorSummary($models, $header = '<div class="alert alert-danger">', $footer = '</div>', $htmlOptions = [])
    {
        return parent::errorSummary($models, $header, $footer, $htmlOptions);
    }


    /**
     * @param FormModel $model
     * @param $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function help(FormModel $model,$attribute, $htmlOptions = [])
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
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
}
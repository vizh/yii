<?php
namespace application\components\attribute;

/**
 * Class BooleanDefinition Definition for the boolean type
 */
class BooleanDefinition extends Definition
{
    /**
     * @inheritdoc
     */
    public $cssClass = 'checkbox';

    /**
     * @inheritdoc
     */
    public function typecast($value)
    {
        return (boolean)$value && $value !== 'false';
    }

    /**
     * @inheritdoc
     */
    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['uncheckValue'] = null;
        $checkbox = \CHtml::activeCheckBox($container, $this->name, $htmlOptions);
        $required = $this->required ? '<span class="required-asterisk">*</span>' : '';

        return \CHtml::label($checkbox . ' ' . $this->title . ' ' . $required, false, [
            'class' => $this->cssClass,
            'style' => $this->cssStyle
        ]) . ($this->placeholder ? \CHtml::tag('small', ['class' => 'notice'], $this->placeholder) : '');
    }

    /**
     * @inheritdoc
     */
    public function getPrintValue($container)
    {
        return parent::getPrintValue($container) ? \Yii::t('app', 'Да') : \Yii::t('app', 'Нет');
    }
}

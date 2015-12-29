<?php
namespace application\components\attribute;

class BooleanDefinition extends Definition
{
    public $cssClass = 'checkbox';

    public function typecast($value)
    {
        return (boolean)$value;
    }

    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['uncheckValue'] = null;
        $checkbox = \CHtml::activeCheckBox($container, $this->name, $htmlOptions);
        return \CHtml::label($checkbox . ' ' . $this->title, false, ['class' => $this->cssClass, 'style' => $this->cssStyle]);
    }

    /**
     * @inheritDoc
     */
    public function getPrintValue($container)
    {
        return parent::getPrintValue($container) ? \Yii::t('app', 'Да') : \Yii::t('app', 'Нет');
    }


}
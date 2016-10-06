<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;
use event\components\UserDataManager;
use Yii;

/**
 * Class BooleanDefinition Definition for the boolean type
 */
class BooleanDefinition extends AbstractDefinition
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
    public function getPrintValue(UserDataManager $manager, $useHtml = false)
    {
        return parent::getPrintValue($manager, $useHtml)
            ? Yii::t('app', 'Да')
            : Yii::t('app', 'Нет');
    }

    /**
     * @inheritdoc
     */
    protected function internalActiveEdit(\CModel $container, array $htmlOptions = [])
    {
        $htmlOptions['uncheckValue'] = null;
        $checkbox = \CHtml::activeCheckBox($container, $this->name, $htmlOptions);
        $required = $this->required ? '<span class="required-asterisk">*</span>' : '';

        return \CHtml::label($checkbox.' '.$this->title.' '.$required, false, [
            'class' => $this->cssClass,
            'style' => $this->cssStyle
        ]).($this->placeholder ? \CHtml::tag('small', ['class' => 'notice'], $this->placeholder) : '');
    }
}

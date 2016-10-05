<?php
namespace application\components\attribute;

/**
 * Class OneSelectDefinition You cane choose only one item
 */
class OneSelectDefinition extends ListDefinition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        if (!$this->customTextField) {
            $rules = [
                [$this->name, 'application\components\validators\RangeValidator', 'range' => array_keys($this->data)]
            ];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        unset($htmlOptions['class']);
        $htmlOptions['style'] = (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');
        $htmlOptions['uncheckValue'] = null;

        $currentValue = $container->{$this->name};
        $valueExists = isset($this->data[$currentValue]);

        $customClass = 'custom-field'.self::$customFieldsCounter++;
        $htmlOptions['class'] = ' '.$customClass;
        $html = '';
        foreach ($this->data as $key => $value) {
            $htmlOptions['value'] = $key;

            $html .= \CHtml::tag('label', ['class' => 'radio'],
                \CHtml::activeRadioButton($container, $this->name, $htmlOptions).' '.$value
            );
        }

        if ($this->customTextField) {
            $htmlOptions['value'] = 'OTHER';
            $htmlOptions['class'] .= ' other-'.$customClass;
            $html .= \CHtml::tag('label', ['class' => 'radio'],
                    \CHtml::radioButton(\CHtml::activeName($container, $this->name), $currentValue && !$valueExists,
                        $htmlOptions).' Другое'
                ).\CHtml::tag('div', [], \CHtml::textField(
                    \CHtml::activeName($container, $this->name),
                    !$valueExists ? $currentValue : '', [
                        'class' => 'span12 text-'.$customClass,
                        'disabled' => $valueExists
                    ]
                ));

            \Yii::app()->getClientScript()->registerScript($customClass,
                "jQuery('.text-$customClass').attr('disabled', true);
                if (jQuery('.other-$customClass').is(':checked')) {jQuery('.text-$customClass').attr('disabled', false);};
                console.log(jQuery('.$customClass'));
                jQuery('.$customClass').click(function () {
                console.log(\$(this).val());
                    if (\$(this).val() === 'OTHER') {
                        jQuery('.text-$customClass').attr('disabled', false);
                    } else {
                        jQuery('.text-$customClass').attr('disabled', true);
                    }
                });"
            );
        }

        return $html;
    }
}
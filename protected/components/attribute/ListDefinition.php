<?php
namespace application\components\attribute;

class ListDefinition extends Definition
{
    /**
     * @var int Counter for the scripts
     */
    static $customFieldsCounter = 0;

    /**
     * @var Definition
     */
    public $valueDefinition;

    /**
     * @var array data for generating the list options (value=>display)
     */
    public $data = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        if (!$this->customTextField) {
            $rules[] = [$this->name, 'in', 'range' => array_keys($this->data)];
        }

        return $rules;
    }


    /**
     * @param mixed $value
     * @return mixed
     */
    public function typecast($value)
    {
        if (!empty($this->valueDefinition) && $this->valueDefinition instanceof Definition) {
            return  $this->valueDefinition->typecast($value);
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['class'] = $this->cssClass . (isset($htmlOptions['class']) ? $htmlOptions['class'] : '');
        $htmlOptions['style'] = $this->cssStyle . (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');

        $currentValue = $container->{$this->name};
        $data = ['' => $this->placeholder] + $this->data;
        $valueExists = isset($data[$currentValue]);

        $customClass = 'custom-field' . self::$customFieldsCounter++;
        if ($this->customTextField) {
            $data += ['OTHER' => 'Другое'];
            $htmlOptions['class'] .= ' '.$customClass;

            if (!$valueExists) {
                $htmlOptions['disabled'] = true;
                $currentValue = 'OTHER';
            }
        }

        $result = \CHtml::dropDownList(\CHtml::activeName($container, $this->name), $currentValue, $data, $htmlOptions);
        if ($this->customTextField) {
            $result .= \CHtml::activeTextField($container, $this->name, [
                'style' => $valueExists ? 'display: none;' : '',
                'class' => 'span12 ' . $customClass.'-custom',
                'disabled' => $valueExists
            ]);

            \Yii::app()->getClientScript()->registerScript($customClass,
                "jQuery('.$customClass').change(function () {
                    var \$this = $(this);

                    if (\$this.val() === 'OTHER') {
                        \$this.prop('disabled', true);
                        \$this.closest('div').find('.$customClass-custom').css('display', 'inline').prop('disabled', false);
                    } else {
                        \$this.prop('disabled', false);
                        \$this.closest('div').find('.$customClass-custom').css('display', 'none').prop('disabled', true);
                    }
                });"
            );
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getPrintValue($container)
    {
        $key = parent::getPrintValue($container);
        return isset($this->data[$key]) ? $this->data[$key] : ($this->customTextField ? $key : '');
    }
}

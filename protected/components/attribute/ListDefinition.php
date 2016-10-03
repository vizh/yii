<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;
use event\components\UserDataManager;

/**
 * Class ListDefinition Definition for list items
 */
class ListDefinition extends AbstractDefinition
{
    /**
     * @var int Counter for the scripts
     */
    static $customFieldsCounter = 0;

    /**
     * @var AbstractDefinition
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
        if (!empty($this->valueDefinition) && $this->valueDefinition instanceof AbstractDefinition) {
            return $this->valueDefinition->typecast($value);
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getPrintValue(UserDataManager $manager, $useHtml = false)
    {
        $key = parent::getPrintValue($manager, $useHtml);

        return isset($this->data[$key]) ? $this->data[$key] : ($this->customTextField ? $key : '');
    }

    /**
     * @inheritdoc
     */
    public function getExportValue(UserDataManager $manager)
    {
        $value = $manager->{$this->name};
        if (is_array($manager->{$this->name})) {
            return implode(', ', $value);
        }

        return (string)$value;
    }

    /**
     * @inheritdoc
     */
    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['class'] = $this->cssClass.(isset($htmlOptions['class']) ? $htmlOptions['class'] : '');
        $htmlOptions['style'] = $this->cssStyle.(isset($htmlOptions['style']) ? $htmlOptions['style'] : '');

        $emptyValue = '';

        $currentValue = $container->{$this->name};
        $data = [$emptyValue => $this->placeholder] + $this->data;
        $valueExists = array_key_exists($emptyValue, $data);

        $customClass = 'custom-field'.self::$customFieldsCounter++;
        if ($this->customTextField) {
            $data += ['OTHER' => 'Другое'];
            $htmlOptions['class'] .= ' '.$customClass;

            if (!$valueExists) {
                $currentValue = 'OTHER';
            }
        }

        $result = \CHtml::dropDownList(\CHtml::activeName($container, $this->name), $currentValue, $data, $htmlOptions);
        if ($this->customTextField) {
            $result .= \CHtml::activeTextField($container, $this->name, [
                'style' => $valueExists ? 'display: none;' : '',
                'class' => 'span12 '.$customClass.'-custom',
                'disabled' => $valueExists
            ]);

            \Yii::app()->getClientScript()->registerScript($customClass,
                "jQuery('.$customClass').change(function () {
                    var \$this = $(this);

                    if (\$this.val() === 'OTHER') {
                        \$this.closest('div').find('.$customClass-custom').css('display', 'inline').prop('disabled', false);
                    } else {
                        \$this.closest('div').find('.$customClass-custom').css('display', 'none').prop('disabled', true);
                    }
                });"
            );
        }

        return $result;
    }
}

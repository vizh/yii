<?php
namespace application\components\attribute;

class ListDefinition extends Definition
{
    /**
     * @var Definition
     */
    public $valueDefinition;

    /**
     * @var array data for generating the list options (value=>display)
     */
    public $data;

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

    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['class'] = $this->cssClass . (isset($htmlOptions['class']) ? $htmlOptions['class'] : '');
        $htmlOptions['style'] = $this->cssStyle . (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');
        return \CHtml::activeDropDownList($container, $this->name, $this->data, $htmlOptions);
    }

    /**
     * @inheritdoc
     */
    public function getPrintValue($container)
    {
        $key = parent::getPrintValue($container);
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }


}
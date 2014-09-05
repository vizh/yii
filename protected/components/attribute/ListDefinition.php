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

    protected function internalActiveEdit(\CModel $container)
    {
        return \CHtml::activeDropDownList($container, $this->name, $this->data, [
            'class' => $this->cssClass,
            'style' => $this->cssStyle
        ]);
    }
}
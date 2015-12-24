<?php
namespace application\components\attribute;

class MultiSelectDefinition extends ListDefinition
{
    public function rules()
    {
        $rules = [
            [$this->name, '\application\components\validators\RangeValidator', 'range' => array_keys($this->data)]
        ];
        return $rules;
    }


    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        unset($htmlOptions['class']);
        $htmlOptions['style'] = (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');
        $htmlOptions['uncheckValue'] = null;

        $html = '';
        foreach ($this->data as $key => $value) {
            $htmlOptions['value'] = $key;
            $html .= \CHtml::tag('label', ['class' => 'checkbox'],
                \CHtml::activeCheckBox($container, $this->name.'[' . $key . ']', $htmlOptions) . ' ' . $value
            );
        }
        return $html;
    }

    /**
     * @inheritdoc
     */
    public function getPrintValue($container)
    {
        $values = [];
        if (is_array($container->{$this->name})) {
            foreach ($container->{$this->name} as $value) {
                $values[] = isset($this->data[$value]) ? $this->data[$value] : '';
            }
        }
        return implode(', ', $values);
    }
}
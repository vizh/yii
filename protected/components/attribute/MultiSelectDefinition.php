<?php
namespace application\components\attribute;

/**
 * Class MultiSelectDefinition
 */
class MultiSelectDefinition extends ListDefinition
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

        $html = '';
        foreach ($this->data as $key => $value) {
            $htmlOptions['value'] = $key;
            $html .= \CHtml::tag('label', ['class' => 'checkbox'],
                \CHtml::activeCheckBox($container, $this->name.'[' . $key . ']', $htmlOptions) . ' ' . $value
            );
        }

        if ($this->customTextField) {
            $html .= \CHtml::label('Другое', '').
                \CHtml::activeTextField($container, $this->name.'[OTHER]', ['class' => 'span12']);
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
                $values[] = isset($this->data[$value]) ? $this->data[$value] : ($this->customTextField ? $value : '');
            }
        }

        return implode(', ', $values);
    }
}

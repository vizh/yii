<?php
namespace application\components\attribute;

/**
 * Class MultiSelectSubListDefinition Implements multi select list definition with sub lists
 */
class MultiSelectSubListDefinition extends ListDefinition
{
    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        unset($htmlOptions['class']);
        $htmlOptions['style'] = (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');

        $html = '';
        foreach ($this->data as $group => $values) {
            $html .= \CHtml::tag('label', ['class' => 'checkbox'],
                \CHtml::activeCheckBox($container, $this->name.'[' . $group . ']', $htmlOptions) . ' ' . $group
            );
            $html .= \CHtml::activeDropDownList($container, $this->name, $values);
        }

        return $html;
    }
}

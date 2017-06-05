<?php
namespace event\widgets\panels\content;

use event\widgets\panels\Base;

class Slider extends Base
{
    const CONTENT_ATTRIBUTE_NAME = 'WidgetContentSliderSlides';

    public function __construct($widget)
    {
        parent::__construct($widget);
        if (!empty($this->form->Attributes[self::CONTENT_ATTRIBUTE_NAME])) {
            foreach ($this->form->Attributes[self::CONTENT_ATTRIBUTE_NAME] as $locale => &$value) {
                $value = unserialize($value);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $this->form->attributes = $request->getParam(get_class($this->form));
        if ($this->showForm && $this->form->validate()) {
            foreach ($this->getWidget()->getAttributeNames() as $name) {
                $attribute = $this->getAttributeActiveRecord($name);
                foreach ($this->form->getLocaleList() as $locale) {
                    $attribute->setLocale($locale);
                    if ($name == self::CONTENT_ATTRIBUTE_NAME) {
                        $value = array_filter($this->form->Attributes[$name][$locale]);
                        $attribute->Value = serialize($value);
                    } else {
                        $attribute->Value = $this->form->Attributes[$name][$locale];
                    }
                    $attribute->save();
                    $attribute->resetLocale();
                }
            }
            $this->setSuccess();
            return true;
        }
        $this->addError($this->form->getErrors());
        return false;
    }

} 
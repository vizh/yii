<?php
namespace application\components\form;

class FormModel extends \CFormModel
{
    /**
     * Заполняет параметры формы из POST запроса
     */
    public function fillFromPost()
    {
        $request = \Yii::app()->getRequest();
        $this->setAttributes($request->getParam(get_class($this)));
    }

    /**
     * Сообщения-подсказки для атрибутов
     * @return array
     */
    public function attributeHelpMessages()
    {
        return [];
    }

    /**
     * @param $attribute
     * @return null
     */
    public function getAttributeHelpMessage($attribute)
    {
        return isset($this->attributeHelpMessages()[$attribute]) ? $this->attributeHelpMessages()[$attribute] : null;
    }
} 
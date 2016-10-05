<?php
namespace application\components\form;

use application\components\traits\ClassNameTrait;
use Yii;

class FormModel extends \CFormModel
{
    use ClassNameTrait;

    /**
     * Заполняет параметры формы из POST запроса
     */
    public function fillFromPost()
    {
        $this->setAttributes(
            Yii::app()->getRequest()->getParam(get_class($this))
        );
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
        $messages = $this->attributeHelpMessages();

        return isset($messages[$attribute])
            ? $messages[$attribute]
            : null;
    }

    /**
     * Возврашает true если форма не пустая
     * @return bool
     */
    public function isNotEmpty()
    {
        foreach ($this->getAttributes() as $name => $value) {
            if ($this->isAttributeRequired($name) && !empty($value)) {
                return true;
            }
        }
        return false;
    }
}
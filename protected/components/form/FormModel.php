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
} 
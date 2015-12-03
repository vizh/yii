<?php
namespace application\components\web;


abstract class SearchFormModel extends \CFormModel
{
    public function init()
    {
        parent::init();
        $request = \Yii::app()->getRequest();
        if ($request->getIsAjaxRequest()) {
            $this->setAttributes($request->getParam(get_class($this)));
        }
    }

    /**
     * @return \CDataProvider
     */
    abstract public function getDataProvider();
} 
<?php
namespace application\components\controllers;

class MainController extends BaseController
{
    public function filters()
    {
        return array_merge(parent::filters(), ['accessControl']);
    }

    /** @var \application\components\auth\AccessControlFilter */
    private $accessFilter;

    public function getAccessFilter()
    {
        if (empty($this->accessFilter)) {
            $this->accessFilter = new \application\components\auth\AccessControlFilter();
            $this->accessFilter->setRules($this->accessRules());
        }
        return $this->accessFilter;
    }

    public function filterAccessControl($filterChain)
    {
        $this->getAccessFilter()->filter($filterChain);
    }

    protected $rules = [];

    public function accessRules()
    {
        if (empty($this->rules)) {
            $this->rules = require(\Yii::getPathOfAlias('application').'/../config/rules.php');
        }
        return $this->rules;
    }
}

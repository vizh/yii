<?php
namespace ruvents2\components;

use application\components\Exception;

class Controller extends \CController
{
    public $writeLog = true;

    public function filters()
    {
        return ['accessControl'];
    }

    /** @var AccessControlFilter */
    private $accessFilter = null;

    public function getAccessFilter()
    {
        if ($this->accessFilter === null) {
            $this->accessFilter = new AccessControlFilter();
            $this->accessFilter->setRules($this->accessRules());
        }
        return $this->accessFilter;
    }

    public function filterAccessControl($filterChain)
    {
        $this->getAccessFilter()->filter($filterChain);
    }

    public function accessRules()
    {
        $rules = \Yii::getPathOfAlias('ruvents2.rules').'.php';
        return require($rules);
    }

    /**
     * @return null|\ruvents2\models\Account
     */
    public function getAccount()
    {
        return WebUser::Instance()->getAccount();
    }

    /**
     * @return null|\ruvents2\models\Operator
     */
    public function getOperator()
    {
        return WebUser::Instance()->getOperator();
    }

    protected $event = null;

    /**
     * @return \event\models\Event|null
     * @throws Exception]
     */
    public function getEvent()
    {
        if ($this->event === null) {
            $this->event = $this->getAccount()->Event;
            if ($this->event === null) {
                throw new Exception('Не найдено мероприятие для текущего RUVENTS-аккаунта');
            }
        }
        return $this->event;
    }

    /**
     * Кодирует данные в JSON формат.
     * Данные преобразуются в JSON формат, вставляются в layout текущего констроллера и отображаются.
     * @param mixed $data данные, которые будут преобразованы в JSON
     */
    public function renderJson($data)
    {
        http_response_code(200);
        // Рендер JSON
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);

        // Оставим за разработчиком право обернуть возвращаемый JSON глобальным JSON объектом
        if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
            $json = $this->renderFile($layoutFile, ['content' => $json], true);

        header('Content-type: application/json; charset=utf-8');
        echo $json;
    }
}
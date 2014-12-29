<?php
namespace ruvents2\components;

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
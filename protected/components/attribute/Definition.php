<?php
namespace application\components\attribute;

/**
 * Class Definition
 * @package common\components\attribute
 * Класс определяющий тип аттрибута и его визуальное представление при редактировании
 */
class Definition
{
    public $name;

    public $title;

    public $groupId = 0;

    public $required = false;

    public $cssStyle = null;

    public $cssClass = null;

    /**
     * @param mixed $value
     * @return mixed
     */
    public function typecast($value)
    {
        return $value;
    }

    /**
     * @param \CModel $container должен быть реализован трейт JsonContainer
     * @param array $htmlOptions
     * @return string
     */
    final public function activeEdit(\CModel $container, $htmlOptions = [])
    {
        return $this->internalActiveEdit($container, $htmlOptions);
    }

    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['class'] = $this->cssClass . (isset($htmlOptions['class']) ? $htmlOptions['class'] : '');
        $htmlOptions['style'] = $this->cssStyle . (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');
        return \CHtml::activeTextField($container, $this->name, $htmlOptions);
    }

    public function rules()
    {
        return [
            [$this->name, 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            [$this->name, $this->required  ? 'required' : 'safe']
        ];
    }

    /**
     * @param string $class
     * @param string $name
     * @param integer $groupId
     * @param array $params
     * @return Definition
     */
    final public static function createDefinition($class, $name, $groupId = 0, $params = [])
    {
        $params['name'] = $name;
        $params['class'] = $class;
        $params['groupId'] = $groupId;
        return \Yii::createComponent($params);
    }

    /**
     * Returns the fully qualified name of this class.
     * @return string the fully qualified name of this class.
     */
    final public static function className()
    {
        return get_called_class();
    }

    /**
     * @param $container
     * @return string
     */
    public function getPrintValue($container)
    {
        return $container->{$this->name};
    }

    /**
     * Метод, вызываемый во время сохранения атрибута
     * @param \CModel $container
     * @return string
     */
    public function internalPush(\CModel $container, $value)
    {
        return $value;
    }

    /**
     * Метод вызывается во время установки параметров модели из request
     * @param \CModel $container
     * @return null|string
     */
    public function internalSetAttribute(\CModel $container)
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $param = $request->getParam(get_class($container));
        return $param !== null && !empty($param[$this->name]) ? $param[$this->name]  : null;
    }
} 
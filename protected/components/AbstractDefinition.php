<?php
namespace application\components;

use CHtml;
use CModel;
use event\components\UserDataManager;
use Yii;

abstract class AbstractDefinition
{
    /**
     * @var string Internal name for the field, this name will be used in forms
     */
    public $name;

    /**
     * @var string Title for the field
     */
    public $title;

    /**
     * @var int Group identifier for the field
     */
    public $groupId = 0;

    /**
     * @var bool Whether this field is required
     */
    public $required = false;

    public $translatable = false;

    /**
     * @var bool Whether show custom
     */
    public $customTextField = false;

    /**
     * @var string Css style for the field
     */
    public $cssStyle;

    /**
     * @var string Css class(es) for the field
     */
    public $cssClass;

    /**
     * @var string Placeholder for the field
     */
    public $placeholder;

    /**
     * @param mixed $value
     * @return mixed
     */
    public function typecast($value)
    {
        return $value;
    }

    /**
     * @param CModel $container должен быть реализован трейт JsonContainer
     * @param array $htmlOptions
     * @return string
     */
    final public function activeEdit(CModel $container, $htmlOptions = [])
    {
        return $this->internalActiveEdit($container, $htmlOptions);
    }

    protected function internalActiveEdit(CModel $container, $htmlOptions = [])
    {
        $htmlOptions['class'] = $this->cssClass.($htmlOptions['class'] ?: '');
        $htmlOptions['style'] = $this->cssStyle.($htmlOptions['style'] ?: '');

        if ($this->placeholder !== null) {
            $htmlOptions['placeholder'] = $this->placeholder;
        }

        if ($this->translatable === false) {
            return CHtml::activeTextField($container, $this->name, $htmlOptions);
        }

        $html = [];

        foreach (Yii::app()->getParams()['Languages'] as $language) {
            $html[] = sprintf('<div class="row"><div class="col-lg-1">%s</div><div class="col-lg-11">%s</div></div>',
                CHtml::activeLabel($container, $this->name, ['label' => $language]),
                CHtml::activeTextField($container, "{$this->name}[{$language}]", $htmlOptions)
            );
        }

        return sprintf('<div class="row"><div class="col-md-6">%s</div></div>',
            implode('</div><div class="col-md-6">', $html)
        );
    }

    /**
     * Правила валидации, применяемые к значению атрибута
     *
     * @return array
     */
    public function rules()
    {
        if ($this->translatable === true) {
            return [
//                [$this->name, 'filter', 'filter' => '\application\components\utility\Texts::clearTranslatable'],
                [$this->name, $this->required ? 'required' : 'safe']
            ];
        } else {
            return [
                [$this->name, 'filter', 'filter' => '\application\components\utility\Texts::clear'],
                [$this->name, $this->required ? 'required' : 'safe']
            ];
        }
    }

    /**
     * @param string $class
     * @param string $name
     * @param integer $groupId
     * @param array $params
     * @return AbstractDefinition
     * @throws \CException
     */
    final public static function createDefinition($class, $name, $groupId = 0, array $params = [])
    {
        $params['name'] = $name;
        $params['class'] = $class;
        $params['groupId'] = $groupId;

        return Yii::createComponent($params);
    }

    /**
     * Returns the fully qualified name of this class.
     *
     * @return string the fully qualified name of this class.
     */
    final public static function className()
    {
        return get_called_class();
    }

    /**
     * Преобразование значения для отображения
     *
     * @param UserDataManager $manager
     * @param bool $useHtml использовать или нет HTML форматирование значения
     * @return string
     */
    public function getPrintValue(UserDataManager $manager, $useHtml = false)
    {
        $value = $manager->{$this->name};

        if ($this->translatable === false) {
            return $value ?: ($useHtml ? '<font color="silver">...</font>' : '');
        }

        if (empty($value) === false && is_array($value) === false)
            return $useHtml ? '<font color="#a52a2a"><u>Неверный формат многоязычного поля!</u></font>' : 'ВНИМАНИЕ!!! Неверный формат многоязычного поля!';

        $html = [];

        foreach (Yii::app()->getParams()['Languages'] as $language) {
            $html[] = sprintf($useHtml ? '<div class="row"><div class="col-lg-1 table-attributes-label">%s</div><div class="col-lg-11">%s</div></div>' : '%s: %s',
                $language,
                $manager->{$this->name}[$language] ?: ($useHtml ? '<font color="silver">...</font>' : '')
            );
        }

        return sprintf($useHtml ? '<div class="row"><div class="col-md-6">%s</div></div>' : '%s',
            implode($useHtml ? '</div><div class="col-md-6">' : ', ', $html)
        );
    }

    /**
     * @param $manager
     * @return string
     */
    public function getExportValue(UserDataManager $manager)
    {
        $value = $manager->{$this->name};

        return empty($value)
            ? null
            : $value;
    }

    /**
     * Метод, вызываемый во время сохранения атрибута
     *
     * @param CModel $container
     * @return string
     */
    public function internalPush(
        /** @noinspection PhpUnusedParameterInspection */
        CModel $container,
        $value
    ) {
        return $value;
    }

    /**
     * Метод вызывается во время установки параметров модели из request
     *
     * @param CModel $container
     * @return null|string
     */
    public function internalSetAttribute(CModel $container)
    {
        $param = Yii::app()
            ->getRequest()
            ->getParam(get_class($container));

        return $param !== null && !empty($param[$this->name])
            ? $param[$this->name]
            : null;
    }

    /**
     * Определяет, поддерживает ли данный тип атрибута локализацию значений.
     *
     * @return bool
     */
    public function isTranslatableAllowed()
    {
        return false;
    }
}
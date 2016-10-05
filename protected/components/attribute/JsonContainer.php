<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;
use application\components\Exception;
use Yii;

/**
 * Class JsonContainer
 *
 * @package common\components\attribute
 * Позволяет работать с key-value хранилищем в заданном json-поле, как со свойствами.
 * Для работы необходима связка Модель-Менеджер. Данный трейт подключается к менеджеру.
 * Обращение к полям: $model->getManager()->Attribute
 *
 * При дополнении класса, унаследованного от yii\base\Model, позволяет использовать валидацию для аттрибутов,
 * хранимых в json контейнере
 */
trait JsonContainer
{
    /**
     * @var \CActiveRecord
     */
    protected $model;

    private $initialized = false;
    /** @var  AbstractDefinition[] */
    private $definitions;
    /**
     * @var Group[]
     */
    private $groups;
    private $attributes = null;

    /**
     * @return \CActiveRecord
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @return AbstractDefinition[]
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param $onlyPublic
     * @return bool
     */
    public function hasDefinitions($onlyPublic = false)
    {
        if ($onlyPublic) {
            $definitions = $this->attributeDefinitions($onlyPublic);

            return !empty($definitions);
        }

        return count($this->definitions) !== 0;
    }

    /**
     * @return Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Метод вызывается перед сохранением модели в БД
     */
    public function pushAttributes()
    {
        foreach ($this->attributes as $name => $value) {
            if (!isset($this->definitions[$name])) {
                continue;
            }
            $value = $this->definitions[$name]->internalPush($this->model(), $value);
            $this->attributes[$name] = $this->definitions[$name]->typecast($value);
        }
        $this->model()->{$this->containerName()} = json_encode($this->attributes, JSON_UNESCAPED_UNICODE);
    }

    public function afterValidateAttributes()
    {
        $manager = $this;
        if ($manager instanceof \CModel && $manager->hasErrors()) {
            $this->model()->addError($this->containerName(), 'Ошибка при валидации дополнительных атрибутов');
        }
    }

    public function attributeLabels()
    {
        $labels = [];
        foreach ($this->definitions as $definition) {
            $labels[$definition->name] = $definition->title;
        }

        return $labels;
    }

    public function __isset($name)
    {
        try {
            /** @noinspection ImplicitMagicMethodCallInspection */
            return $this->__get($name) !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Возвращает список атрибутов как есть, без обработки.
     * Использовать с осторожностью.
     *
     * @return array
     */
    public function getRawData()
    {
        return $this->attributes;
    }

    /**
     * Устанавливает список атрибутов как есть, без обработки.
     * Использовать с осторожностью.
     *
     * @param array $attributes
     */
    public function setRawData(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function __get($name)
    {
        if (!isset($this->definitions[$name])) {
            throw new Exception("Атрибут '$name' не определён для данного мероприятия");
        }

        if (isset($this->attributes[$name]) === false) {
            return null;
        }

        $value = $this->attributes[$name];

        /** @noinspection NotOptimalIfConditionsInspection */
        if (isset($value['ru']) === true && false === defined('YII_TRANSlATABLE_ATTRIBUTE_FORCE_RAW_VALUES')) {
            return $value[Yii::app()->language];
        }

        return $value;
    }

    public function __set($name, $value)
    {
        if (!isset($this->definitions[$name])) {
            throw new Exception('Установка неизвестного аттрибута: '.get_class($this).'::'.$name);
        }

        $this->attributes[$name] = $value;
    }

    public function __unset($name)
    {
        if (!isset($this->definitions[$name])) {
            throw new Exception('Удаление неизвестного аттрибута: '.get_class($this).'::'.$name);
        }

        // toDo: Разобраться почему unset тут не работает.

        $attributes = [];
        foreach ($this->attributes as $attr => $value) {
            if ($attr != $name) {
                $attributes[$attr] = $value;
            }
        }

        $this->attributes = $attributes;
    }

    /**
     * Возвращает список названий аттрибутов
     * Необходим для совместимости с \CModel, в случае если нужна валидация
     *
     * @return array list of attribute names.
     */
    public function attributeNames()
    {
        return array_keys($this->definitions);
    }

    /**
     * Инициализация контейнера.
     * Создаются Definitions
     * Загружаются атрибуты из модели
     * Добавляются события в модель
     *
     * @throws \CException
     */
    protected function initJsonContainer(\CActiveRecord $model)
    {
        if (!$this->initialized) {
            $this->model = $model;
            $this->createGroups();
            $this->createDefinitions();
            $this->pullAttributes();
            $this->model()->attachEventHandler('onBeforeSave', [$this, 'pushAttributes']);
            $this->model()->attachEventHandler('onAfterValidate', [$this, 'afterValidateAttributes']);
        }
    }

    private function createGroups()
    {
        $this->groups = [];
        if (count($this->attributeGroups()) !== 0) {
            foreach ($this->attributeGroups() as $group) {
                $this->groups[$group[0]] = new Group($group[0], isset($group[1]) ? $group[1] : '',
                    isset($group[2]) ? $group[2] : '');
            }
        } else {
            $this->groups[0] = new Group();
        }
    }

    private function createDefinitions()
    {
        $this->definitions = [];
        foreach ($this->attributeDefinitions() as $definition) {
            if (is_string($definition)) {
                $this->definitions[$definition] = AbstractDefinition::createDefinition(Definition::className(),
                    $definition);
            } elseif (is_array($definition) && isset($definition[0], $definition[1])) {
                $this->definitions[$definition[0]] = AbstractDefinition::createDefinition(
                    '\application\components\attribute\\'.$definition[1],
                    $definition[0],
                    isset($definition[2]) ? $definition[2] : 0,
                    array_slice($definition, 3)
                );
            } else {
                throw new \CException('Invalid definition: a definition must specify both attribute name and definition type.');
            }

            /** @var AbstractDefinition $definitionObject */
            $definitionObject = end($this->definitions);
            if (isset($this->groups[$definitionObject->groupId])) {
                $this->groups[$definitionObject->groupId]->addDefinition($definitionObject);
            } else {
                throw new \CException(sprintf('Invalid definition group "%s": a definition must specify real group name or leave empty group name.',
                    $definitionObject->groupId));
            }
        }
    }

    private function pullAttributes()
    {
        if ($this->attributes === null) {
            $attributesData = $this->model()->{$this->containerName()};
            $this->attributes = !empty($attributesData)
                ? json_decode($attributesData, true)
                : [];

            // Если попадутся невалидные данные
            if (!is_array($this->attributes)) {
                $this->attributes = [];
            }
        }
    }

    /**
     * Имя json-поля модели, для хранения данных
     *
     * @return string
     */
    protected abstract function containerName();

    /**
     * Описание хранимых в контейнере аттрибутов.
     * Возможны 2 способа задания:
     * 1. ['Name1', 'Name2', ...] - список имен хранимых полей. В данном случае все поля
     * определяют объекты класса Definition
     * 2. [['Name', 'DefinitionClass', 'GroupId', ...params], ...] - каждое хранимое поле определяется тем классом,
     * который был указан после имени поля. Также возможно задать дополнительные параметры,
     * соответствующие DefinitionClass.
     *
     * @param boolean $onlyPublic
     * @return string[]|array
     */
    protected abstract function attributeDefinitions($onlyPublic = false);

    /**
     * Описание разбивки аттрибутов по группам. Группы выводятся в той последовательности, как возвращаются этим методом
     * [['Name', 'Title', 'Description'], ...]
     *
     * @return array
     */
    protected function attributeGroups()
    {
        return [];
    }

    /**
     * @return array
     * @see \CModel::rules()
     * Возвращает данные в таком же формате, как указанный метод
     */
    final protected function definitionRules()
    {
        $rules = [];
        foreach ($this->definitions as $definition) {
            $definitionRules = $definition->rules();
            if (empty($definitionRules)) {
                $definitionRules = [[$definition->name, 'safe']];
            }
            $rules = array_merge($rules, $definitionRules);
        }

        return $rules;
    }
}
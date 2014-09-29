<?php
namespace application\components\attribute;

use application\components\Exception;

/**
 * Class JsonContainer
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
    /**
     * Инициализация контейнера.
     * Создаются Definitions
     * Загружаются атрибуты из модели
     * Добавляются события в модель
     */
    protected function initJsonContainer(\CActiveRecord $model)
    {
        if (!$this->initialized) {
            $this->model = $model;
            $this->createGroups();
            $this->createDefinitions();
            $this->pullAttributes();
            $this->model()->attachEventHandler('onBeforeSave', [$this, 'pushAttributes']);
            $this->model()->attachEventHandler('onBeforeValidate', [$this, 'validateAttributes']);
        }
    }

    /**
     * @return \CActiveRecord
     */
    protected function model()
    {
        return $this->model;
    }

    /**
     * Имя json-поля модели, для хранения данных
     * @return string
     */
    protected abstract function containerName();

    /** @var  Definition[] */
    private $definitions;

    /**
     * Описание хранимых в контейнере аттрибутов.
     * Возможны 2 способа задания:
     * 1. ['Name1', 'Name2', ...] - список имен хранимых полей. В данном случае все поля
     * определяют объекты класса Definition
     * 2. [['Name', 'DefinitionClass', 'GroupId', ...params], ...] - каждое хранимое поле определяется тем классом,
     * который был указан после имени поля. Также возможно задать дополнительные параметры,
     * соответствующие DefinitionClass.
     * @return string[]|array
     */
    protected abstract function attributeDefinitions();

    private function createDefinitions()
    {
        $this->definitions = [];
        foreach ($this->attributeDefinitions() as $definition) {
            if (is_string($definition)) {
                $this->definitions[$definition] = Definition::createDefinition(Definition::className(), $definition);
            } elseif (is_array($definition) && isset($definition[0], $definition[1])) {
                $this->definitions[$definition[0]] = Definition::createDefinition('\application\components\attribute\\'.$definition[1], $definition[0], isset($definition[2]) ? $definition[2] : 0, array_slice($definition, 3));
            } else {
                throw new \CException('Invalid definition: a definition must specify both attribute name and definition type.');
            }

            /** @var Definition $definitionObject */
            $definitionObject = end($this->definitions);
            if (isset($this->groups[$definitionObject->groupId])) {
                $this->groups[$definitionObject->groupId]->addDefinition($definitionObject);
            } else {
                throw new \CException(sprintf('Invalid definition group "%s": a definition must specify real group name or leave empty group name.', $definitionObject->groupId));
            }
        }
    }

    /**
     * @return Definition[]
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @return bool
     */
    public function hasDefinitions()
    {
        return count($this->definitions) !== 0;
    }

    /**
     * @var Group[]
     */
    private $groups;

    /**
     * Описание разбивки аттрибутов по группам. Группы выводятся в той последовательности, как возвращаются этим методом
     * [['Name', 'Title', 'Description'], ...]
     * @return array
     */
    protected function attributeGroups()
    {
        return [];
    }

    private function createGroups()
    {
        $this->groups = [];
        if (count($this->attributeGroups()) !== 0) {
            foreach ($this->attributeGroups() as $group) {
                $this->groups[$group[0]] = new Group($group[0], isset($group[1])?$group[1]:'', isset($group[2])?$group[2]:'');
            }
        } else {
            $this->groups[0] = new Group();
        }
    }

    /**
     * @return Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    private $attributes = null;

    private function pullAttributes()
    {
        if ($this->attributes === null) {
            $this->attributes = !empty($this->model()->{$this->containerName()}) ?
                json_decode($this->model()->{$this->containerName()}, true) :
                [];
        }
    }

    /**
     * Метод вызывается перед сохранением модели в БД
     */
    public function pushAttributes()
    {
        foreach ($this->attributes as $name => $value) {
            $this->attributes[$name] = $this->definitions[$name]->typecast($value);
        }
        $this->model()->{$this->containerName()} = json_encode($this->attributes, JSON_UNESCAPED_UNICODE);
    }

    public function validateAttributes()
    {
        $manager = $this;
        if ($manager instanceof \CModel && !$manager->validate()) {
            $this->model()->addError($this->containerName(), 'Ошибка при валидации дополнительных атрибутов');
        }
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

    public function attributeLabels()
    {
        $labels = [];
        foreach ($this->definitions as $definition) {
            $labels[$definition->name] = $definition->title;
        }
        return $labels;
    }

    public function __get($name)
    {
        if (!isset($this->definitions[$name]))
            throw new Exception('Получение неизвестного аттрибута: ' . get_class($this) . '::' . $name);
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function __set($name, $value)
    {
        if (!isset($this->definitions[$name]))
            throw new Exception('Установка неизвестного аттрибута: ' . get_class($this) . '::' . $name);
        $this->attributes[$name] = $value;
    }

    public function __isset($name)
    {
        try {
            return $this->__get($name) !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function __unset($name)
    {
        if (!isset($this->definitions[$name]))
            throw new Exception('Удаление неизвестного аттрибута: ' . get_class($this) . '::' . $name);
        unset($this->attributes[$name]);
    }

    /**
     * Возвращает список названий аттрибутов
     * Необходим для совместимости с \CModel, в случае если нужна валидация
     * @return array list of attribute names.
     */
    public function attributeNames()
    {
        return array_keys($this->definitions);
    }
} 
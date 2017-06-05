<?php

namespace ruvents2\components\data;

abstract class AbstractBuilder
{
    private $__result = [];

    /**
     * Синтаксический сахар для упрощения использования
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /*
     * Сеттеры для конфигурации строителей
     */
    public function __call($method, $arguments)
    {

        if (strpos($method, 'set') === 0) {
            $var = strtolower(substr($method, 3, 1)).substr($method, 4);
            $this->$var = $arguments[0];
        }

        return $this;
    }

    /**
     * Данный метод имплементируется конкретными строителями для рассчёта данных
     */
    abstract protected function buildData();

    /**
     * Рассчёт и возвращение данных
     * @return array|null
     */
    public function build()
    {
        $this->buildData();
        return $this->__result;
    }

    /**
     * Откладывает данные для дальнейшего возвращения в качестве результата. Возможно передать сразу массив.
     * @param array|string $name наименование параметра или массив данных
     * @param object|null $value значение
     */
    protected function stash($name, $value = null)
    {
        if ($value === null && is_array($name)) {
            $this->__result = array_merge($this->__result, $name);
        } else {
            $this->__result[$name] = $value;
        }
    }
}
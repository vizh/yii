<?php
namespace application\widgets\grid;

abstract class FilterWidget extends \CWidget
{
    /** @var GridView */
    public $grid;

    /** @var \CFormModel */
    public $model;

    /** @var string */
    public $attribute;

    /**
     * Имя js функции, используемая для инициализации виджета
     *
     * @return string|null
     */
    public function getInitJsFunctionName()
    {
        return null;
    }
} 
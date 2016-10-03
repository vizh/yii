<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;

class Group
{
    public $id;

    public $title;

    public $description;
    /**
     * @var AbstractDefinition[]
     */
    private $definitions = [];

    public function __construct($id = '', $title = '', $description = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    public function addDefinition(AbstractDefinition $definition)
    {
        $this->definitions[] = $definition;
    }

    /**
     * @return AbstractDefinition[]
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}
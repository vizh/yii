<?php
namespace application\components\attribute;

class Group
{
    public $id;

    public $title;

    public $description;

    public function __construct($id = '', $title = '', $description = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @var Definition[]
     */
    private $definitions = [];

    public function addDefinition(Definition $definition)
    {
        $this->definitions[] = $definition;
    }

    /**
     * @return Definition[]
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
} 
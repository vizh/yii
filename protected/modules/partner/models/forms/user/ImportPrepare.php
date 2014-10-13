<?php
namespace partner\models\forms\user;


use event\models\Event;
use event\models\UserData;

class ImportPrepare extends \CFormModel
{

    private $columns;

    /** @var Event */
    private $event;

    private $values = [];

    /**
     * @param string[] $columns
     * @param Event $event
     * @param string $scenario
     */
    public function __construct($columns, $event, $scenario = '')
    {
        parent::__construct($scenario);
        $this->columns = $columns;
        $this->event = $event;
    }

    public function __get($name)
    {
        if (in_array($name, $this->columns))
        {
            return isset($this->values[$name]) ? $this->values[$name] : '';
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->columns))
        {
            return $this->values[$name] = $value;
        }
        return parent::__set($name, $value);
    }

    public function __isset($name)
    {
        if (in_array($name, $this->columns))
        {
            return isset($this->values[$name]);
        }
        return parent::__isset($name);
    }


    public function getColumns()
    {
        return $this->columns;
    }

    private $attributeNames = null;
    public function attributeNames()
    {
        if ($this->attributeNames == null)
        {
            $this->attributeNames = array_merge(parent::attributeNames(), $this->columns);
        }
        return $this->attributeNames;
    }

    public $Notify = false;
    public $NotifyEvent = false;
    public $Visible = false;

    public function rules()
    {
        return [
            [implode(',', $this->attributeNames()), 'safe'],
            [implode(',', $this->columns), 'required']
        ];
    }

    private $columnValues = null;

    public function getColumnValues()
    {
        if ($this->columnValues === null) {
            $this->columnValues = [
                '' => 'Выбрать',
                'LastName' => 'Фамилия',
                'FirstName' => 'Имя',
                'FatherName' => 'Отчество',
                'Email' => 'Email',
                'Phone' => 'Телефон',
                'Company' => 'Компания',
                'Position' => 'Должность',
                'Role' => 'Статус',
                'Product' => 'Товар',
                'ExternalId' => 'Внешний ID'
            ];

            $userData = new UserData();
            $userData->EventId = $this->event->Id;
            foreach ($userData->getManager()->getDefinitions() as $definition) {
                $this->columnValues[$definition->name] = $definition->title;
            }
        }
        return $this->columnValues;
    }

}
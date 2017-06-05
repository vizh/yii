<?php
namespace application\modules\partner\models\search;

use application\components\AbstractDefinition;
use application\components\attribute\ListDefinition;
use application\components\form\SearchFormModel;
use event\models\Event;
use event\models\UserData;
use user\models\User;

class ParticipantData extends SearchFormModel
{
    public $User;

    /**
     * @var AbstractDefinition[]
     */
    private $definitions = [];

    /** @var Event */
    private $event;

    /** @var array */
    private $values = [];

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct('');
    }

    public function init()
    {
        $this->definitions = $this->event->getAttributeDefinitions();
        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->definitions)) {
            return isset($this->values[$name]) ? $this->values[$name] : '';
        }
        return parent::__get($name);
    }

    /**
     * @inheritDoc
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->definitions)) {
            return ($this->values[$name] = $value);
        }
        return parent::__set($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        $rules = [
            [implode(',', array_keys($this->definitions)), 'filter', 'filter' => '\application\components\utility\Texts::clear']
        ];
        $rules[] = ['User', 'filter', 'filter' => '\application\components\utility\Texts::clear'];
        return $rules;
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        return new \CActiveDataProvider('event\models\UserData', [
            'criteria' => $this->getCriteria(),
            'sort' => $this->getSort(),
            'pagination' => [
                'pageSize' => 30,
            ]
        ]);
    }

    /**
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        $criteria = UserData::model()
            ->byEventId($this->event->Id)
            ->byDeleted(false)
            ->with(['User'])
            ->getDbCriteria();

        if ($this->validate()) {
            if (!empty($this->User)) {
                $users = User::model()
                    ->bySearch($this->User, null, true, false)->byEmail($this->User, false)->findAll();

                $criteria->addInCondition('"t"."UserId"', \CHtml::listData($users, 'Id', 'Id'));
            }

            foreach ($this->values as $name => $value) {
                if (!empty($value)) {
                    $criteria->addCondition('"t"."Attributes"::TEXT ILIKE :'.$name);
                    $criteria->params[$name] = '%"'.$name.'":"%'.$value.'%"%';
                }
            }
        }
        return $criteria;
    }

    /**
     * @return \CSort
     */
    public function getSort()
    {
        $sort = new \CSort();
        $sort->attributes = [
            'User' => [
                'asc' => '"User"."RunetId" ASC',
                'desc' => '"User"."RunetId" DESC'
            ],
            'CreationTime'
        ];
        $sort->defaultOrder = ['CreationTime' => true];
        return $sort;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        $columns = [
            [
                'name' => 'User',
                'header' => 'Участник',
                'type' => 'raw',
                'value' => function (UserData $data) {
                    return \Yii::app()->getController()->renderPartial(
                        '../partial/grid/user',
                        ['user' => $data->User],
                        true
                    );
                },
                'htmlOptions' => ['class' => 'text-left']
            ],
            [
                'name' => 'CreationTime',
                'header' => 'Дата заполнения',
                'value' => 'Yii::app()->getDateFormatter()->format("dd MMMM yyyy HH:mm", $data->CreationTime)',
                'filter' => false,
                'width' => 200
            ],
        ];

        foreach ($this->definitions as $definition) {
            $column = [
                'type' => 'raw',
                'name' => $definition->name,
                'header' => $definition->title,
                'value' => function (UserData $data) use ($definition) {
                    $manager = $data->getManager();
                    if (isset($manager->{$definition->name})) {
                        return $definition->getPrintValue($manager);
                    }
                    return null;
                },
                'width' => (60 / sizeof($this->definitions)).'%'
            ];
            if ($definition instanceof ListDefinition) {
                $column['filter'] = $definition->data;
            }
            $columns[] = $column;
        }

        return $columns;
    }
}

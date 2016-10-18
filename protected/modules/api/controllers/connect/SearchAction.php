<?php
namespace api\controllers\connect;

use application\components\helpers\ArrayHelper;
use CDbCriteria;
use event\models\Participant;
use Yii;

class SearchAction extends \api\components\Action
{
    public function run()
    {
        $participants = Participant::model()
            ->with('Data', 'User')
            ->byEventId($this->getEvent()->Id);


        if ($this->hasRequestParam('RoleId')){
            $participants->byRoleId($this->getRequestParam('RoleId'));
        }

        if ($this->hasRequestParam('Attributes')) {
            foreach ($this->getRequestParam('Attributes') as $name => $value) {
                $participants->byAttributeLike($name, $value);
            }
        }

        if ($this->hasRequestParam('q')){
            $participants->bySearchString($this->getRequestParam('q'));
        }

        $result = [];
        foreach ($participants->findAll() as $participant) {
            $result[] = $this->getDataBuilder()->createUser($participant->User);
        }

        $sort = ArrayHelper::merge(
            ['Attribute' => 'Name', 'Direction' => 'asc'],
            $this->getRequestParam('Sort', [])
        );

        $attributes = ['Name' => 'FullName', 'RegDate' => 'CreationTime'];
        $directions = ['asc' => SORT_ASC, 'desc' => SORT_DESC];

        ArrayHelper::multisort(
            $result,
            $attributes[$sort['Attribute']],
            $directions[strtolower($sort['Direction'])]
        );

        $this->setResult(['Success' => true, 'Users' => $result]);
    }
}
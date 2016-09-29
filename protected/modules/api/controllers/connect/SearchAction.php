<?php
namespace api\controllers\connect;

use application\components\helpers\ArrayHelper;
use event\models\Participant;

class SearchAction extends \api\components\Action
{
    public function run()
    {
        $participants = Participant::model()
            ->with('Data', 'User')
            ->byEventId($this->getEvent()->Id);
        $criteria = new \CDbCriteria();

        $roleId = \Yii::app()->request->getParam('RoleId', null);
        if ($roleId){
            $participants->byRoleId($roleId);
        }

        $attributes = \Yii::app()->request->getParam('Attributes', []);
        foreach ($attributes as $attributeName => $attributeValue) {
            $criteria->addCondition('"Data"."Attributes"->>\''.$attributeName.'\' ilike \'%'.$attributeValue.'%\'');
        }

        $participants->dbCriteria->mergeWith($criteria);
        $participants = $participants->findAll();

        $result = [];
        foreach ($participants as $participant) {
            $result[] = $this->getDataBuilder()->createUser($participant->User);
        }

        $sort = \Yii::app()->request->getParam('Sort', []);
        $sort = ArrayHelper::merge(['Attribute' => 'Name', 'Direction' => 'asc'], $sort);
        $attributes = [
            'Name' => 'FullName',
            'RegDate' => 'CreationTime'
        ];
        $directions = [
            'asc' => SORT_ASC,
            'desc' => SORT_DESC
        ];
        ArrayHelper::multisort($result, $attributes[$sort['Attribute']], $directions[strtolower($sort['Direction'])]);

        $this->setResult(['Success' => true, 'Users' => $result]);
    }
}
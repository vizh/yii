<?php
namespace api\controllers\connect;

use application\components\helpers\ArrayHelper;
use CDbCriteria;
use event\models\Participant;
use Yii;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param;

class SearchAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Поиск",
     *     description="Поиск по участникам мероприятия.",
     *     request=@Request(
     *          method="GET",
     *          url="/connect/search",
     *          body="",
     *          params={
     *              @Param(title="RoleId", description="Роль участника.", mandatory="N"),
     *              @Param(title="Attributes", description="Атрибуты.", mandatory="N"),
     *              @Param(title="q", description="Поисковый запрос", mandatory="N"),
     *          },
     *          response=@Response(body="{'Success': true, 'Users': ['Объект USER']}")
     *      )
     * )
     */
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
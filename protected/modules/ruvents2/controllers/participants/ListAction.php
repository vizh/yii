<?php
namespace ruvents2\controllers\participants;

use api\models\ExternalUser;
use application\components\helpers\ArrayHelper;
use ruvents2\components\Action;
use ruvents2\components\data\builders\UserBuilder;
use ruvents2\components\data\CDbCriteria;
use ruvents2\models\forms\ParticipantListRequest;
use user\models\User;
use Yii;

class ListAction extends Action
{
    public function run()
    {
        $params = new ParticipantListRequest();

        $users = User::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll(
                CDbCriteria::create()
                    ->mergeWith($this->getDetailedCriteria($params))
                    ->addInCondition('t."Id"', $this->getNextExcerptPage($params))
            );

        $builder = UserBuilder::create()
            ->setEvent($this->getEvent())
            ->setApiAccount($this->getApiAccount());

        foreach ($users as &$user) {
            $user = $builder->setUser($user)
                ->build();
        }

        $this->renderJson([
            'Participants' => $users,
            'NextSince' => $params->since,
            'NextFount' => $params->Fount
        ]);
    }

    /**
     * Получает следующую страницу незавершённой постраничной выборки
     *
     * @param ParticipantListRequest $params
     * @return array
     */
    private function getNextExcerptPage(ParticipantListRequest $params)
    {
        $cache = Yii::app()->getCache();

        if ($params->Fount) {
            /* Если имеется ключ незавершённой постраничной навигации, забираем
             * оставшиеся необработанными идентификаторы оттуда */
            $users = $cache->get('excerpt:participants:'.$params->Fount);
        } else {
            /* Выбираем идентификаторы посетителей, удовлетворяющие запросу */
            $criteria = CDbCriteria::create()
                ->setSelect('t."Id"')
                ->setOrder('t."UpdateTime" ASC');

            if ($params->since) {
                $criteria->addConditionWithParams('t."UpdateTime" > :UpdateTime', ['UpdateTime' => $params->since]);
            }

            /* Дата следующего запроса запоминается каждый раз перед выборкой посетителей
             * Важно, чтобы клиент запрашивал обновления именно с этой даты */
            $params->since = date('Y-m-d H:i:s');

            $users = ArrayHelper::columnGet('Id',
                User::model()
                    ->byEventId($this->getEvent()->Id)
                    ->findAll($criteria)
            );
        }

        /* Забираем очередную порцию идентификаторов посетителей на обработку */
        $excerpt = array_splice($users, 0, $params->limit);

        if (count($users)) {
            /* Если остались необработанные идентификаторы, то запишем их для следующей обработки */
            if ($params->Fount === null) {
                $params->Fount = md5(implode([microtime(true), mt_rand()]));
            };

            $cache->delete('excerpt:participants:'.$params->Fount);
            $cache->add('excerpt:participants:'.$params->Fount, $users, Yii::app()->params['RuventsFountLifetime']);
        } else {
            /* Если необработанных посетителей не осталось, - очищаем хранилище */
            if ($params->Fount) {
                $cache->delete('excerpt:participants:'.$params->Fount);
                $params->Fount = null;
            }
        }

        return $excerpt;
    }

    /**
     * Критерий для выборки данных посетителей.
     *
     * @param ParticipantListRequest $params
     * @return CDbCriteria
     */
    private function getDetailedCriteria(ParticipantListRequest $params)
    {
        $criteria = CDbCriteria::create()
            ->setLimit($params->limit)
            ->setWith([
                'Employments' => ['together' => false],
                'Employments.Company' => ['together' => false],
                'LinkPhones.Phone' => ['together' => false],
                'Badges' => [
                    'together' => false,
                    'on' => '"Badges"."EventId" = :EventId',
                    'params' => ['EventId' => $this->getEvent()->Id]
                ]
            ]);

        if ($this->hasExternalId()) {
            $criteria->with['ExternalAccounts'] = [
                'together' => false,
                'on' => '"ExternalAccounts"."AccountId" = :AccountId',
                'params' => ['AccountId' => $this->getApiAccount()->Id]
            ];
        }

        return $criteria;
    }

    /**
     * @return bool
     */
    private function hasExternalId()
    {
        static $hasExternalId;

        if ($hasExternalId === null) {
            $hasExternalId = $this->getApiAccount() !== null
                ? ExternalUser::model()->byAccountId($this->getApiAccount()->Id)->exists()
                : false;
        }

        return $hasExternalId;
    }
}
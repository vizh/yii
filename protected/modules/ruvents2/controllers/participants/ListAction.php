<?php
namespace ruvents2\controllers\participants;

use api\models\ExternalUser;
use application\components\helpers\ArrayHelper;
use CDbCriteria;
use ruvents2\components\Action;
use ruvents2\components\data\UserBuilder;
use user\models\User;
use Yii;

class ListAction extends Action
{
    const MAX_LIMIT = 1000;
    const PAGE_CACHE_TIME = 60;

    private $limit;
    private $since;
    private $fount;

    public function run($since = null, $limit = null)
    {
        $this->since = $since;
        $this->limit = ($limit = intval($limit)) > 0
            ? min($limit, self::MAX_LIMIT)
            : self::MAX_LIMIT;

        $users = User::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll($this->getDetailedCriteria());

        $builder = UserBuilder::create()
            ->setEvent($this->getEvent())
            ->setApiAccount($this->getApiAccount());

        foreach ($users as &$user) {
            $user = $builder->setUser($user)
                ->build();
        }

        $this->renderJson([
            'Participants' => $users,
            'NextSince' => $this->since ?: date('Y-m-d H:i:s'),
            'NextFount' => $this->fount
        ]);
    }

    private function getNextUsersPage() {
        $this->fount = Yii::app()->getRequest()->getQuery('Fount', $this->getExcerptHash());
        $users = Yii::app()->getCache()->get($this->fount);

        if ($users === false)
            $users = ArrayHelper::columnGet('RunetId',
                User::model()
                    ->byEventId($this->getEvent()->Id)
                    ->findAll($this->getBaseCriteria())
            );

        $usersPage = array_splice($users, 0, $this->limit);

        if (count($users) > 0) {
            /* Запомним оставшиеся RunetId для обработки следующим запросом */
            Yii::app()->getCache()->set($this->fount, $users, self::PAGE_CACHE_TIME);
        } else {
            /* Удаляем хранилище с уже обработанными участниками */
            Yii::app()->getCache()->delete($this->fount);
            $this->fount = null;
        }

        return $usersPage;
    }

    /**
     * Критерий для быстрой выборки идентификаторов посетителей. Не добавляет связей с другими таблицами,
     * использует только
     * @return CDbCriteria
     */
    private function getBaseCriteria()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't."UpdateTime"';

        if ($this->since !== null) {
            $criteria->addCondition('t."UpdateTime" >= :UpdateTime');
            $criteria->params['UpdateTime'] = date('Y-m-d H:i:s', strtotime($this->since));
        }

        return $criteria;
    }

    /**
     * Критерий для выборки данных посетителей.
     * @return CDbCriteria
     */
    private function getDetailedCriteria()
    {
        $criteria = $this->getBaseCriteria();
        $criteria->addInCondition('t."RunetId"', $this->getNextUsersPage());
        $criteria->limit = $this->limit;

        $criteria->with = [
            'Employments' => ['together' => false],
            'Employments.Company' => ['together' => false],
            'LinkPhones.Phone' => ['together' => false],
            'Badges' => [
                'together' => false,
                'on' => '"Badges"."EventId" = :EventId',
                'params' => ['EventId' => $this->getEvent()->Id]
            ]
        ];

        if ($this->hasExternalId()) {
            $criteria->with['ExternalAccounts'] = [
                'together' => false,
                'on' => '"ExternalAccounts"."AccountId" = :AccountId',
                'params' => ['AccountId' => $this->getApiAccount()->Id]
            ];
        }

        return $criteria;
    }

    /** @var null|bool */
    private $hasExternalId = null;

    /**
     * @return bool
     */
    private function hasExternalId()
    {
        if ($this->hasExternalId === null)
            $this->hasExternalId = $this->getApiAccount() !== null
                ? ExternalUser::model()->byAccountId($this->getApiAccount()->Id)->exists()
                : false;

        return $this->hasExternalId;
    }

    /**
     * Генерирует идентификатор выборки для кеширования постраничной отдачи запроса
     * @return string
     */
    private function getExcerptHash()
    {
        static $excerpt;

        if ($excerpt == null)
            $excerpt = md5(implode([microtime(true), self::getOperator()->Id]));

        return $excerpt;
    }
}
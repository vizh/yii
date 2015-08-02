<?php
namespace ruvents2\controllers\participants;

use api\models\Account;
use api\models\ExternalUser;
use application\components\helpers\ArrayHelper;
use CDbCriteria;
use ruvents2\components\Action;
use user\models\User;
use Yii;

class ListAction extends Action
{
    const MAX_LIMIT = 500;
    const PAGE_CACHE_TIME = 60;

    private $limit;
    private $since;
    private $hasMore;
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

        $this->renderJson([
            'Participants' => array_map(['self', 'getData'], $users),
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

    /**
     * @param User $user
     * @return array
     */
    private function getData($user)
    {
        $data = ArrayHelper::toArray($user, ['user\models\User' => ['Id' => 'RunetId', 'CreationTime', 'Email', 'Birthday']]);
        if ($this->hasExternalId() && !empty($user->ExternalAccounts)) {
            $data['ExternalId'] = $user->ExternalAccounts[0]->ExternalId;
        }
        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $data['Position'] = $employment->Position;
        }

        foreach (Yii::app()->params['Languages'] as $lang) {
            $user->setLocale($lang);
            $localeData = ArrayHelper::toArray($user, ['user\models\User' => ['LastName', 'FirstName', 'FatherName']]);
            if ($employment !== null) {
                $employment->Company->setLocale($lang);
                $localeData['Company'] = $employment->Company->Name;
            }
            $data['Locales'][$lang] = $localeData;
        }
        if (!empty($user->PrimaryPhone)) {
            $data['Phone'] = $user->PrimaryPhone;
        } elseif ($user->getContactPhone() !== null) {
            $data['Phone'] = $user->getContactPhone()->__toString();
        }
        $data['Photo'] = 'http://' . RUNETID_HOST . $user->getPhoto()->get200px();

        $data['RegistrationTime'] = null;

        $statuses = [];
        foreach ($user->Participants as $participant) {
            $statuses[] = [
                'StatusId' => $participant->RoleId,
                'PartId' => $participant->PartId
            ];
            if ($data['RegistrationTime'] == null || $data['RegistrationTime'] > $participant->UpdateTime) {
                $data['RegistrationTime'] = $participant->UpdateTime;
            }
        }
        $data['Statuses'] = $statuses;
        $data['BadgesCount'] = sizeof($user->Badges);
        return $data;
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

    /** @var bool|Account|null */
    private $apiAccount = false;

    /**
     * @return Account|null
     */
    private function getApiAccount()
    {
        if ($this->apiAccount === false) {
            $this->apiAccount = Account::model()->byEventId($this->getEvent()->Id)->find();
        }
        return $this->apiAccount;
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
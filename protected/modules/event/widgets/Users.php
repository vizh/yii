<?php
namespace event\widgets;

class Users extends \event\components\Widget
{
    public $criteria;
    public $showCounter = true;
    public $showPagination = false;

    private $users;
    private $paginator;

    private function getUsers()
    {
        if ($this->users == null) {
            $userModel = \user\models\User::model()->byEventId($this->event->Id)->byVisible();
            $mainCriteria = new \CDbCriteria($userModel->getDbCriteria());
            $mainCriteria->order = $this->showCounter ? '"Participants"."CreationTime" DESC' : '"t"."LastName" ASC';
            $mainCriteria->with[] = 'Settings';

            if ($this->criteria !== null) {
                $mainCriteria->mergeWith($this->criteria);
            }

            $criteria = new \CDbCriteria();
            $criteria->mergeWith($mainCriteria);
            $criteria->with['Participants']['select'] = false;
            $criteria->select = '"t"."Id", "t"."RunetId"';
            $userIdList = [];
            foreach ($userModel->findAll($criteria) as $user) {
                $userIdList[$user->Id] = $user->RunetId;
            }

            $this->paginator = new \application\components\utility\Paginator($userModel->count($criteria));
            $this->paginator->perPage = \Yii::app()->params['EventViewUserPerPage'];
            if (!$this->showCounter) {
                $this->paginator->perPage *= 2;
            }
            $mainCriteria->addInCondition('"t"."RunetId"', array_slice($userIdList, $this->paginator->getOffset(), $this->paginator->perPage));
            $mainCriteria->with = array_merge($mainCriteria->with, [
                'Settings',
                'Employments',
                'Participants.Role'
            ]);
            $this->users = $userModel->findAll($mainCriteria);
        }
        return $this->users;
    }

    private function getPaginator()
    {
        return $this->paginator;
    }

    public function run()
    {
        $this->render('users', ['users' => $this->getUsers(), 'paginator' => $this->getPaginator()]);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Участники');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Tabs;
    }

    /**
     *
     * @return bool
     */
    public function getIsActive()
    {
        return sizeof($this->getUsers()) > 0;
    }
}

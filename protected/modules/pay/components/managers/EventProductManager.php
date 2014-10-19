<?php
namespace pay\components\managers;
use event\models\Participant;
use pay\models\OrderItem;

/**
 * @property int $RoleId
 */
class EventProductManager extends BaseProductManager
{
    /**
     * @inheritdoc
     */
    public function getProductAttributeNames()
    {
        return array_merge(['RoleId'], parent::getProductAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredProductAttributeNames()
    {
        return ['RoleId'];
    }


    /** @var \event\models\Participant */
    protected $participant;

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    public function checkProduct($user, $params = array())
    {
        $this->participant = \event\models\Participant::model()
            ->byUserId($user->Id)
            ->byEventId($this->product->EventId)->with('Role')->find();
        if ($this->participant === null)
        {
            return true;
        }
        $role = \event\models\Role::model()->findByPk($this->RoleId);
        if ($role === null)
        {
            return false;
        }

        return $this->participant->Role->Priority < $role->Priority;
    }

    protected function getCheckProductMessage($user, $params = [])
    {
        if ($this->participant != null)
        {
            $isSelf = !\Yii::app()->user->isGuest && \Yii::app()->user->getCurrentUser()->Id == $user->Id;
            $roleTitle = $this->participant->Role->Title;

            if ($this->participant->RoleId == 64) {
                return 'К сожалению, на данный момент Вы не можете оплатить участие в DevCon 2014, т.к. все места на конференцию уже забронированы, и Вы переведены в лист ожидания. При появлении свободных мест мы обязательно с Вами свяжемся.';
            }


            if ($isSelf)
                return sprintf('Вы уже зарегистрированы на мероприятие со статусом "%s"', $roleTitle);
            else
                return sprintf('%s уже зарегистрирован на мероприятие со статусом "%s"', $user->getFullName(), $roleTitle);
        }
        return parent::getCheckProductMessage($user, $params);
    }


    /**
     * @param \user\models\User $user
     * @param \pay\models\OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    protected function internalBuy($user, $orderItem = null, $params = array())
    {
        /** @var $role \event\models\Role */
        $role = \event\models\Role::model()->findByPk($this->RoleId);
        $this->product->Event->registerUser($user, $role);
        return true;
    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    protected function internalChangeOwner($fromUser, $toUser, $params = array())
    {
        $participant = \event\models\Participant::model()->byEventId($this->product->EventId)
            ->byRoleId($this->RoleId)->byUserId($fromUser->Id)->find();
        if ($participant !== null) {
            // todo: Необходимо по логу смотреть прошлый перед оплатой статус, и выставлять его
            $participant->delete();
        }

        return $this->internalBuy($toUser);
    }

    /**
     * @inheritdoc
     */
    protected function internalRollback(OrderItem $orderItem)
    {
        $owner = $orderItem->getCurrentOwner();
        $participant = Participant::model()->byEventId($this->product->EventId)
            ->byRoleId($this->RoleId)->byUserId($owner->Id)->find();
        if ($participant != null) {
            // todo: аналогично internalChangeOwner
            $participant->delete();
        }
    }

    /**
     * @param array $params
     * @param string $filter
     * @return array
     */
    public function filter($params, $filter)
    {
        return array();
    }

    /**
     * @param array $params
     * @return \pay\models\Product
     */
    public function getFilterProduct($params)
    {
        return $this->product;
    }

}

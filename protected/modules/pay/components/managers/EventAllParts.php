<?php
namespace pay\components\managers;

use event\models\Participant;
use pay\components\MessageException;
use pay\models\OrderItem;

/**
 * @property $RoleId
 */
class EventAllParts extends BaseProductManager
{
    /**
     * Возвращает список доступных аттрибутов
     * @return string[]
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


    /** @var \event\models\Role */
    protected $role = null;

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     *
     * @param \user\models\User $user
     * @param array $params
     *
     * @throws \pay\components\Exception
     * @return bool
     */
    public function checkProduct($user, $params = array())
    {
        if (sizeof($this->product->Event->Parts) === 0) {
            throw new MessageException('Данное мероприятие не имеет логической разбивки. Используйте продукт регистрации на всё мероприятие.');
        }

        $this->role = \event\models\Role::model()->findByPk($this->RoleId);
        if ($this->role === null) {
            throw new MessageException('Не корректно установлена роль на мероприятии для товара категории EventOnPart');
        }

        /** @var $participants \event\models\Participant[] */
        $participants = \event\models\Participant::model()
            ->byEventId($this->product->EventId)->byUserId($user->Id)->with('Role')->findAll();

        foreach ($participants as $participant)
        {
            if ($participant->Role->Priority >= $this->role->Priority)
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Оформляет покупку продукта на пользователя
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    public function internalBuy($user, $orderItem = null, $params = array())
    {
        $this->product->Event->registerUserOnAllParts($user, $this->role);

        return true;
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

    /**
     * @inheritdoc
     */
    protected function internalRollback(OrderItem $orderItem)
    {
        $owner = $orderItem->getCurrentOwner();
        $participants = Participant::model()->byEventId($this->product->EventId)
            ->byRoleId($this->RoleId)->byUserId($owner->Id)->findAll();
        foreach ($participants as $participant) {
            // todo: проверять по логу прошлый статус и менять на него
            $participant->delete();
        }
    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @throws \pay\components\Exception
     * @return bool
     */
    public function internalChangeOwner($fromUser, $toUser, $params = array())
    {
        throw new MessageException('Не реализовано');
        if (!$this->CheckProduct($toUser))
        {
            return false;
        }
        list($roleId) = $this->GetAttributes($this->GetAttributeNames());
        $role = \event\models\Role::GetById($roleId);
        if (empty($role))
        {
            return false;
        }

        /** @var $participants \event\models\Participant[] */
        $participants = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($fromUser->UserId)->findAll();

        foreach ($participants as $participant)
        {
            if ($participant->RoleId == $roleId)
            {
                $participant->delete();
            }
        }

        /** @var $participants \event\models\Participant[] */
        $participants = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($toUser->UserId)->with('EventRole')->findAll();

        $days = $this->product->Event->Days;
        $daysByKey = array();
        foreach ($days as $day)
        {
            $daysByKey[$day->DayId] = $day;
        }

        foreach ($participants as $participant)
        {
            unset($daysByKey[$participant->DayId]);
            if ($participant->Role->Priority > $role->Priority)
            {
                continue;
            }
            $participant->UpdateRole($role);
        }

        foreach ($daysByKey as $day)
        {
            $this->product->Event->RegisterUserOnDay($day, $toUser, $role);
        }

        return true;
    }
}
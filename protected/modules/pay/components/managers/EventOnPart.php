<?php
namespace pay\components\managers;

/**
 * @property int $RoleId
 * @property int $PartId
 */
class EventOnPart extends BaseProductManager
{
    /**
     * Возвращает список доступных аттрибутов
     * @return string[]
     */
    public function getProductAttributeNames()
    {
        return array_merge(['RoleId', 'PartId'], parent::getProductAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredProductAttributeNames()
    {
        return ['RoleId', 'PartId'];
    }

    /** @var \event\models\Role */
    protected $role = null;

    /** @var \event\models\Part */
    protected $part = null;

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
        /** @var $part \event\models\Part */
        $this->part = \event\models\Part::model()->findByPk($this->PartId);
        if ($this->part === null || $this->part->EventId != $this->product->EventId)
        {
            throw new \pay\components\Exception('Не корректно задан PartId для товара категории EventOnPart');
        }
        $this->role = \event\models\Role::model()->findByPk($this->RoleId);
        if ($this->role === null)
        {
            throw new \pay\components\Exception('Не корректно установлена роль на мероприятии для товара категории EventOnPart');
        }

        /** @var $eventUser \event\models\Participant */
        $participant = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($user->Id)->byPartId($this->PartId)->find();
        if (empty($participant))
        {
            return true;
        }

        return $participant->Role->Priority < $this->role->Priority;
    }

    /**
     * Оформляет покупку продукта на пользователя
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    public function internalBuyProduct($user, $orderItem = null, $params = array())
    {
        $this->product->Event->registerUserOnPart($this->part, $user, $this->role);

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
     * Отменяет покупку продукта на пользовтеля
     * @param \user\models\User $user
     * @return bool
     */
    public function rollbackProduct($user)
    {
        throw new \pay\components\Exception('Не реализовано');
        /** @var $orderItem \pay\models\OrderItem */
        $orderItem = \pay\models\OrderItem::model()->find(
            't.Paid = 1 AND t.OwnerId = :OwnerId AND t.ProductId = :ProductId',
            array(
                ':OwnerId' => $user->UserId,
                ':ProductId' => $this->product->ProductId
            ));

        if ( $orderItem != null)
        {
            $orderItem->Paid = 0;
            $orderItem->PaidTime = null;
            $orderItem->save();
        }
        else
        {
            return false;
        }

        list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());

        /** @var $participant \event\models\Participant */
        $participant = \event\models\Participant::model()->byUserId($user->UserId)->byEventId($this->product->EventId)->byDayId($dayId)->find();

        if ($participant != null)
        {
            $participant->UpdateRole($participant->Event->DefaultRole);
            return true;
        }
        return false;
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
        throw new \pay\components\Exception('Не реализовано');
        if (!$this->CheckProduct($toUser))
        {
            return false;
        }
        list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());

        /** @var $participant \event\models\Participant */
        $participant = \event\models\Participant::model()
            ->byUserId($fromUser->UserId)
            ->byEventId($this->product->EventId)
            ->byDayId($dayId)->find();

        if ($participant != null)
        {
            if ($participant->RoleId == $roleId)
            {
                $participant->delete();
            }
        }

        $role = \event\models\Role::GetById($roleId);
        if (empty($role))
        {
            return false;
        }

        /** @var $participant \event\models\Participant */
        $participant = \event\models\Participant::model()
            ->byUserId($toUser->UserId)
            ->byEventId($this->product->EventId)
            ->byDayId($dayId)->find();
        if (empty($participant))
        {
            $this->product->Event->RegisterUser($toUser, $role);
        }
        else
        {
            $participant->UpdateRole($role);
        }

        return true;
    }
}

<?php
namespace pay\components\managers;

use event\models\Participant;
use pay\components\MessageException;
use pay\models\OrderItem;

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
    public function checkProduct($user, $params = [])
    {
        /** @var $part \event\models\Part */
        $this->part = \event\models\Part::model()->findByPk($this->PartId);
        if ($this->part === null || $this->part->EventId != $this->product->EventId) {
            throw new MessageException('Не корректно задан PartId для товара категории EventOnPart');
        }
        $this->role = \event\models\Role::model()->findByPk($this->RoleId);
        if ($this->role === null) {
            throw new MessageException('Не корректно установлена роль на мероприятии для товара категории EventOnPart');
        }

        /** @var $eventUser \event\models\Participant */
        $participant = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($user->Id)->byPartId($this->PartId)->find();
        if (empty($participant)) {
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
    public function internalBuy($user, $orderItem = null, $params = [])
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
        return [];
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
        $participant = Participant::model()
            ->byEventId($this->product->EventId)
            ->byUserId($owner->Id)
            ->byRoleId($this->RoleId)
            ->byPartId($this->PartId)
            ->find();

        if ($participant !== null) {
            $participant->Event->unregisterUserOnPart($owner, $participant->Part, \Yii::t('app', 'Отмена заказа'));
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
    public function internalChangeOwner($fromUser, $toUser, $params = [])
    {
        throw new MessageException('Не реализовано');
    }
}

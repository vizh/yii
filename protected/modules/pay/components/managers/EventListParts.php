<?php
namespace pay\components\managers;

use event\models\Participant;
use pay\components\MessageException;
use pay\models\OrderItem;

/**
 * @property int $RoleId
 * @property int $PartIdList
 */
class EventListParts extends BaseProductManager
{
    /**
     * Возвращает список доступных аттрибутов
     * @return string[]
     */
    public function getProductAttributeNames()
    {
        return array_merge(['RoleId', 'PartIdList'], parent::getProductAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredProductAttributeNames()
    {
        return ['RoleId', 'PartIdList'];
    }

    /** @var \event\models\Role */
    protected $role = null;

    /** @var \event\models\Part[] */
    private $parts = null;

    protected function getParts()
    {
        if ($this->parts == null)
        {
            $idList = preg_split('/[ ,]/', $this->PartIdList, -1, PREG_SPLIT_NO_EMPTY);
            $criteria = new \CDbCriteria();
            $criteria->addInCondition('"t"."Id"', $idList);
            $this->parts = \event\models\Part::model()->findAll($criteria);
            if (empty($this->parts))
            {
                throw new MessageException('Не корректно задан PartIdList для товара категории EventListParts. Идентификатор товара: ' . $this->product->Id);
            }
            foreach ($this->parts as $part)
            {
                if ($part->EventId != $this->product->EventId)
                    throw new MessageException('Не корректно задана одна из частей параметра PartIdList для товара категории EventListParts. Идентификатор товара: ' . $this->product->Id);
            }
        }

        return $this->parts;
    }

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
            throw new MessageException('Не корректно установлена роль на мероприятии для товара категории EventListParts');
        }

        /** @var $participants \event\models\Participant[] */
        $participants = \event\models\Participant::model()
            ->byEventId($this->product->EventId)->byUserId($user->Id)->with('Role')->findAll();

        foreach ($participants as $participant)
        {
            foreach ($this->getParts() as $part)
            {
                if ($participant->PartId == $part->Id && $participant->Role->Priority >= $this->role->Priority)
                {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Оформляет покупку продукта на пользователя
     *
     * @param \user\models\User $user
     * @param \pay\models\OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    protected function internalBuy($user, $orderItem = null, $params = array())
    {
        foreach ($this->getParts() as $part)
        {
            $this->product->Event->registerUserOnPart($part, $user, $this->role);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function internalRollback(OrderItem $orderItem)
    {
        $owner = $orderItem->getCurrentOwner();
        $partIdList = preg_split('/[ ,]/', $this->PartIdList, -1, PREG_SPLIT_NO_EMPTY);
        $participants = Participant::model()->byEventId($this->product->EventId)
            ->byUserId($owner->Id)->byRoleId($this->RoleId)->byPartId($partIdList)->findAll();
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
     * @return bool
     */
    protected function internalChangeOwner($fromUser, $toUser, $params = array())
    {
        throw new MessageException('Не реализовано');
        // TODO: Implement internalChangeOwner() method.
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
}
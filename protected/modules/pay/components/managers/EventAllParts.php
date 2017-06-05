<?php
namespace pay\components\managers;

use event\models\Participant;
use event\models\Role;
use pay\components\MessageException;
use pay\models\OrderItem;
use user\models\User;

/**
 * @property int $RoleId
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

    /**
     * @var Role
     */
    protected $role;

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     *
     * @param User $user
     * @param array $params
     *
     * @throws \pay\components\Exception
     * @return bool
     */
    public function checkProduct($user, $params = [])
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

        foreach ($participants as $participant) {
            if ($participant->Role->Priority >= $this->role->Priority) {
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
    public function internalBuy($user, $orderItem = null, $params = [])
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
        $participants = Participant::model()->byEventId($this->product->EventId)->byRoleId($this->RoleId)->byUserId($owner->Id)->findAll();
        if (empty($participants)) {
            return false;
        }
        foreach ($participants as $participant) {
            $participant->Event->unregisterUserOnPart($owner, $participant->Part, \Yii::t('app', 'Отмена заказа'));
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function internalChangeOwner($fromUser, $toUser, $params = [])
    {
        $transaction = \Yii::app()->getDb()->beginTransaction();

        try {
            $participants = Participant::model()
                ->byEventId($this->product->EventId)
                ->byRoleId($this->RoleId)
                ->byUserId($fromUser->Id)
                ->findAll();

            if (count($participants)) {
                foreach ($participants as $participant) {
                    // todo: Необходимо по логу смотреть прошлый перед оплатой статус, и выставлять его
                    $participant->delete();
                }
            }

            $orderItems = OrderItem::model()->findAll('"ProductId" = :productId AND "OwnerId" = :userId', [
                ':productId' => $this->product->Id,
                ':userId' => $fromUser->Id
            ]);

            foreach ($orderItems as $orderItem) {
                $orderItem->OwnerId = $toUser->Id;
                $orderItem->save();
            }

            $result = $this->internalBuy($toUser);

            $transaction->commit();

            return $result;
        } catch (\CDbException $e) {
            return false;
        }
    }
}

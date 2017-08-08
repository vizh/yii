<?php
namespace pay\components\managers;

use event\models\Participant;
use event\models\Role;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;
use Yii;

/**
 * @property int $RoleId
 */
class EventProductManager extends BaseProductManager
{
    /**
     * @var Participant
     */
    protected $participant;

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

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     * @param User $user
     * @param array $params
     * @return bool
     */
    public function checkProduct($user, $params = [])
    {
        $this->participant = Participant::model()
            ->byUserId($user->Id)
            ->byEventId($this->product->EventId)
            ->with('Role')
            ->find();

        if ($this->participant === null) {
            return true;
        }

        if (null === $role = Role::model()->findByPk($this->RoleId)) {
            return false;
        }

        return $this->participant->Role->Priority < $role->Priority;
    }

    /**
     * @inheritdoc
     */
    protected function getCheckProductMessage($user, $params = [])
    {
        if ($this->participant != null) {
            $isSelf = !Yii::app()->user->isGuest && Yii::app()->user->getCurrentUser()->Id == $user->Id;
            $roleTitle = $this->participant->Role->Title;

            return $isSelf
                ? sprintf('Вы уже зарегистрированы на мероприятие со статусом "%s"', $roleTitle)
                : sprintf('%s уже зарегистрирован на мероприятие со статусом "%s"', $user->getFullName(), $roleTitle);
        }

        return parent::getCheckProductMessage($user, $params);
    }

    /**
     * @param User $user
     * @param OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    protected function internalBuy($user, $orderItem = null, $params = [])
    {
        $this->product->Event->registerUser(
            $user,
            Role::model()->findByPk($this->RoleId)
        );

//        if ($this->product->Event->IdName === 'startupvillage17') {
//            (new Client())->post('http://sv17.ruvents.com/runet-id/payed', [
//                'json' => [
//                    'RunetId' => $user->RunetId,
//                    'ProductId' => $this->product->Id
//                ]
//            ]);
//        }

        return true;
    }

    /**
     *
     * @param User $fromUser
     * @param User $toUser
     * @param array $params
     *
     * @return bool
     */
    protected function internalChangeOwner($fromUser, $toUser, $params = [])
    {
        $participant = Participant::model()
            ->byEventId($this->product->EventId)
            ->byRoleId($this->RoleId)
            ->byUserId($fromUser->Id)
            ->find();

        if ($participant) {
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
        $participant = Participant::model()
            ->byEventId($this->product->EventId)
            ->byRoleId($this->RoleId)
            ->byUserId($owner->Id)
            ->find();

        if ($participant) {
            $participant->Event->unregisterUser($owner, Yii::t('app', 'Отмена заказа'));
            return true;
        }

        return false;
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
     * @return Product
     */
    public function getFilterProduct($params)
    {
        return $this->product;
    }
}

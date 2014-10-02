<?php
namespace pay\components\managers;
use string;

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
    protected function internalBuyProduct($user, $orderItem = null, $params = array())
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
        $participant = \event\models\Participant::model()
            ->byUserId($fromUser->Id)->byEventId($this->product->EventId)->find();
        if ($participant !== null)
        {
            if ($participant->RoleId == $this->RoleId)
            {
                $participant->delete();
            }
        }

        return $this->internalBuyProduct($toUser);
    }


    /**
     * @param \user\models\User $user
     *
     * @return bool
     */
    public function rollbackProduct($user)
    {
        $orderItem = \pay\models\OrderItem::model()
            ->byOwnerId($user->Id)->byProductId($this->product->Id)->byPaid(true)->find();

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

        $participant = \event\models\Participant::model()
            ->byEventId($this->product->EventId)->byUserId($user->Id)->find();
        if ($participant != null)
        {
            $participant->UpdateRole($participant->Event->DefaultRole);
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

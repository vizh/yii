<?php
namespace api\components\ms;


use event\models\Role;
use pay\models\OrderItem;
use user\models\User;

class DevconEventRoleConverter
{
    const EVENT_ID = 2319;

    /**
     * Роль, с для которой применять преобразование
     */
    const CONVERT_FROM_ROLE_ID = 1;

    /**
     * Карта соответствия купленного товара к выдаваемой роли
     * @var array
     */
    private static $PRODUCT_ID_ROLE_ID_MAP = [
        4019 => 243,
        4013 => 242,
        4015 => 241,
        4016 => 241,
        4017 => 241,
        4018 => 241
    ];

    /**
     * Преобразовывает из исходной роли к необходимой
     * @param User $user
     * @param Role $initialRole
     * @return Role
     */
    public static function convert(User $user, Role $initialRole)
    {
        if ($initialRole->Id === self::CONVERT_FROM_ROLE_ID) {
            $product = self::getConvertedPaidProduct($user);
            if ($product !== null) {
                return Role::model()->findByPk(self::$PRODUCT_ID_ROLE_ID_MAP[$product->Id]);
            }
        }
        return $initialRole;
    }

    /**
     * Востанавливает роль в прежнее состояние
     * @param Role $role
     * @return Role
     */
    public static function restore(Role $role)
    {
        if (in_array($role->Id, self::$PRODUCT_ID_ROLE_ID_MAP)) {
            return Role::model()->findByPk(self::CONVERT_FROM_ROLE_ID);
        }
        return $role;
    }

    /**
     * @param User $user
     * @return null|\pay\models\Product
     */
    private static function getConvertedPaidProduct(User $user)
    {
        $orderItems = OrderItem::model()
            ->byEventId(self::EVENT_ID)
            ->byAnyOwnerId($user->Id)
            ->byPaid(true)
            ->findAll();

        foreach ($orderItems as $orderItem) {
            if (array_key_exists($orderItem->ProductId, self::$PRODUCT_ID_ROLE_ID_MAP)) {
                return $orderItem->Product;
            }
        }
        return null;
    }
}
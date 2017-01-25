<?php
namespace pay\models;

use application\models\translation\ActiveRecord;
use event\models\Event;

/**
 * @property int $Id
 * @property int $EventId
 * @property bool $Own
 * @property string $OrderTemplateName
 * @property string $ReturnUrl
 * @property string $Offer
 * @property string $OrderLastTime
 * @property bool $OrderEnable
 * @property bool $Uniteller
 * @property bool $UnitellerRuvents
 * @property bool $PayOnline
 * @property bool $PayOnlineRuvents
 * @property bool $CloudPayments
 * @property bool $WalletOne
 * @property bool $MailRuMoney
 * @property int $OrderTemplateId
 * @property bool $SandBoxUser
 * @property string $SandBoxUserRegisterUrl
 * @property string $ReceiptName
 * @property int $ReceiptTemplateId
 * @property string $ReceiptLastTime
 * @property bool $ReceiptEnable
 * @property string $OrderDisableMessage
 * @property int $OrderMinTotal
 * @property string $OrderMinTotalMessage
 * @property string $AfterPayUrl
 * @property string $CabinetIndexTabTitle
 * @property string $CabinetHasRecentPaidItemsMessage
 * @property string $CabinetJuridicalCreateInfo
 *
 * @property Event $Event
 * @property OrderJuridicalTemplate $OrderTemplate
 * @property OrderJuridicalTemplate $ReceiptTemplate
 *
 * Описание вспомогательных методов
 * @method Account   with($condition = '')
 * @method Account   find($condition = '', $params = [])
 * @method Account   findByPk($pk, $condition = '', $params = [])
 * @method Account   findByAttributes($attributes, $condition = '', $params = [])
 * @method Account[] findAll($condition = '', $params = [])
 * @method Account[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Account byId(int $id, bool $useAnd = true)
 * @method Account byEventId(int $id, bool $useAnd = true)
 * @method Account byOwn(bool $own, bool $useAnd = true)
 */
class Account extends ActiveRecord
{
    /**
     * @param string $className
     * @return Account
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayAccount';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'OrderTemplate' => [self::BELONGS_TO, '\pay\models\OrderJuridicalTemplate', 'OrderTemplateId'],
            'ReceiptTemplate' => [self::BELONGS_TO, '\pay\models\OrderJuridicalTemplate', 'ReceiptTemplateId'],
        ];
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['OrderDisableMessage'];
    }
}

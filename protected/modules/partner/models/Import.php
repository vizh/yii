<?php
namespace partner\models;

use api\models\Account;

/**
 * Class Import
 * @package partner\models
 *
 * @property int $Id
 * @property int $EventId
 * @property string $Fields
 * @property string $Roles
 * @property bool $Notify
 * @property bool $NotifyEvent
 * @property bool $Visible
 * @property string $CreationTime
 * @property string $Products
 *
 * Relations
 * @property ImportUser[] $Users
 * @property \event\models\Event $Event
 *
 * @method \partner\models\Import findByPk($pk)
 */
class Import extends \CActiveRecord
{
    /**
     * @var Account
     */
    private $apiAccount;

    /**
     * @static
     * @param string $className
     * @return Import
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PartnerImport';
    }

    /**
     * @inheritdoc
     */
    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Users' => [self::HAS_MANY, 'partner\models\ImportUser', 'ImportId'],
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId']
        ];
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        $path = \Yii::getPathOfAlias('partner.data.' . $this->EventId . '.import');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $path . DIRECTORY_SEPARATOR . $this->Id;
    }

    /**
     * @return Account
     */
    public function getApiAccount()
    {
        if ($this->apiAccount === null) {
            $this->apiAccount = Account::model()->byEventId($this->EventId)->find();
        }

        return $this->apiAccount;
    }
}

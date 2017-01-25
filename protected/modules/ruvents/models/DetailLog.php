<?php
namespace ruvents\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $OperatorId
 * @property int $UserId
 * @property string $Controller
 * @property string $Action
 * @property string $Changes
 * @property string $CreationTime
 *
 * @property Operator $Operator
 *
 * Описание вспомогательных методов
 * @method DetailLog   with($condition = '')
 * @method DetailLog   find($condition = '', $params = [])
 * @method DetailLog   findByPk($pk, $condition = '', $params = [])
 * @method DetailLog   findByAttributes($attributes, $condition = '', $params = [])
 * @method DetailLog[] findAll($condition = '', $params = [])
 * @method DetailLog[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method DetailLog byId(int $id, bool $useAnd = true)
 * @method DetailLog byEventId(int $id, bool $useAnd = true)
 * @method DetailLog byOperatorId(int $id, bool $useAnd = true)
 * @method DetailLog byUserId(int $id, bool $useAnd = true)
 * @method DetailLog byController(string $controller, bool $useAnd = true)
 * @method DetailLog byAction(string $action, bool $useAnd = true)
 */
class DetailLog extends ActiveRecord
{
    /** @var ChangeMessage[] */
    private $changeMessages = null;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsDetailLog';
    }

    public function relations()
    {
        return [
            'Operator' => [self::BELONGS_TO, '\ruvents\models\Operator', 'OperatorId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }

    /**
     * @param ChangeMessage $changeMessages
     */
    public function addChangeMessage($changeMessages)
    {
        if ($this->changeMessages === null) {
            $this->changeMessages = [];
        }
        $this->changeMessages[] = $changeMessages;
    }

    public function getChangeMessages()
    {
        if ($this->changeMessages === null) {
            $this->changeMessages = unserialize(base64_decode($this->Changes));
        }

        return $this->changeMessages;
    }

    public function beforeSave()
    {
        if (parent::beforeSave() && $this->changeMessages !== null) {
            $this->Changes = base64_encode(serialize($this->changeMessages));

            return true;
        }

        return false;
    }

    /**
     * @return DetailLog
     */
    public function createBasic()
    {
        $clone = new DetailLog();
        $clone->EventId = $this->EventId;
        $clone->OperatorId = $this->OperatorId;
        $clone->UserId = $this->UserId;
        $clone->Controller = $this->Controller;
        $clone->Action = $this->Action;

        return $clone;
    }
}

<?php
namespace event\models;

use application\models\translation\ActiveRecord;

/**
 * Fields
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property int $Priority
 * @property string $Color
 * @property bool $Visible
 * @property bool $Notification
 *
 * @method Role find($condition = '', $params = [])
 * @method Role findByPk($pk,$condition = '', $params = [])
 * @method Role[] findAll($condition = '', $params = [])
 */
class Role extends ActiveRecord implements \JsonSerializable
{
    const PARTICIPANT = 1;
    const VISITOR = 38;
    const VIRTUAL_ROLE_ID = 24;
    const VOLUNTEER = 153;

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'EventRole';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Participants' => [self::HAS_MANY, 'event\models\Participant', 'RoleId']
        ];
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Participants"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $criteria->with = ['Participants' => ['together' => true, 'select' => false]];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param bool $base
     * @param bool $useAnd
     * @return $this
     */
    public function byBase($base = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$base ? 'NOT ' : '').'"t"."Base"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Title'];
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->Title;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'Id' => $this->Id,
            'Name' => $this->Title,
            'Color' => $this->Color
        ];
    }
}

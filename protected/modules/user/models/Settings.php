<?php
namespace user\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $Verify
 * @property int $Agreement
 * @property int $IndexProfile
 * @property string $WhoView
 * @property int  $ProjNews Новости системы rocID
 * @property int  $EventNews Еженедельный дайджест событий на rocID
 * @property int  $NoticePhoto Уведомлять о фотографиях и видео, на которых вас отметили
 * @property int  $NoticeMsg
 * @property int  $NoticeProfile
 * @property int  $HideFatherName
 * @property int  $HideBirthdayYear
 * @property bool $UnsubscribeAll Отписан ли пользователь от всех рассылок. Он ещё может быть отписан только от рассылок конкретного мероприятия, но в другом месте.
 * @property bool $UnsubscribePush Отписан ли пользователь ото всех push нотификаций.
 *
 * Описание вспомогательных методов
 * @method Settings   with($condition = '')
 * @method Settings   find($condition = '', $params = [])
 * @method Settings   findByPk($pk, $condition = '', $params = [])
 * @method Settings   findByAttributes($attributes, $condition = '', $params = [])
 * @method Settings[] findAll($condition = '', $params = [])
 * @method Settings[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Settings byId(int $id, bool $useAnd = true)
 * @method Settings byUserId(int $id, bool $useAnd = true)
 */
class Settings extends ActiveRecord
{
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
        return 'UserSettings';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\modelsUser', 'UserId'],
        ];
    }
}

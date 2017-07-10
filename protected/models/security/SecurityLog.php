<?php

namespace application\models\security;

use application\components\ActiveRecord;
use application\components\Exception;
use Yii;

/**
 * @property int $Id
 * @property int $UserId
 * @property string $Model
 * @property string $ModelAction
 * @property string $Attributes
 * @property string $Changes
 * @property string $CreateTime
 *
 * @property \user\models\User $User
 *
 * Описание вспомогательных методов
 *
 * @method SecurityLog   with($condition = '')
 * @method SecurityLog   find($condition = '', $params = [])
 * @method SecurityLog   findByPk($pk, $condition = '', $params = [])
 * @method SecurityLog   findByAttributes($attributes, $condition = '', $params = [])
 * @method SecurityLog[] findAll($condition = '', $params = [])
 * @method SecurityLog[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method SecurityLog byUserId(int $id)
 * @method SecurityLog byModel(string $model)
 * @method SecurityLog byModelAction(string $action)
 */
class SecurityLog extends ActiveRecord
{
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

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
        return 'SecurityLog';
    }

    public function behaviors()
    {
        return [
            ['class' => '\application\extensions\behaviors\TimestampableBehavior'],
            ['class' => '\application\extensions\behaviors\DeletableBehavior']
        ];
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }

    public function rules()
    {
        return [
            ['ModelAction', 'in', 'range' => [self::ACTION_CREATE, self::ACTION_UPDATE, self::ACTION_DELETE]]
        ];
    }

    /**
     * @param string $action
     *
     * @return self|null
     *
     * @throws Exception
     */
    public static function create($action)
    {
        $webUser = Yii::app()->getUser();

        if ($webUser instanceof \application\components\auth\WebUser && null !== $user = $webUser->getCurrentUser()) {
            $log = new self();
            $log->UserId = $user->Id;
            $log->ModelAction = $action;

            return $log;
        }

        return null;
    }

    protected function beforeSave()
    {
        if (false === is_string($value = $this->Attributes)) {
            $this->Attributes = false === empty($value)
                ? json_encode($value, JSON_UNESCAPED_UNICODE)
                : '{}';
        }

        if (false === is_string($value = $this->Changes)) {
            $this->Changes = false === empty($value)
                ? json_encode($value, JSON_UNESCAPED_UNICODE)
                : '{}';
        }

        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->setAttributes([
            'Attributes' => json_decode($this->Attributes),
            'Changes' => json_decode($this->Changes)
        ]);

        return parent::afterFind();
    }

}

<?php
namespace job\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $PositionId
 * @property string $Position
 * @property string $Text
 * @property int $SalaryFrom
 * @property int $SalaryTo
 * @property string $CrateTime
 * @property bool $Visible
 * @property job\models\Job $job
 *
 * Описание вспомогательных методов
 * @method JobUp   with($condition = '')
 * @method JobUp   find($condition = '', $params = [])
 * @method JobUp   findByPk($pk, $condition = '', $params = [])
 * @method JobUp   findByAttributes($attributes, $condition = '', $params = [])
 * @method JobUp[] findAll($condition = '', $params = [])
 * @method JobUp[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method JobUp byId(int $id, bool $useAnd = true)
 * @method JobUp byCompanyId(int $id, bool $useAnd = true)
 * @method JobUp byPositionId(int $id, bool $useAnd = true)
 * @method JobUp byVisibleId(int $id, bool $useAnd = true)
 */
class JobUp extends ActiveRecord
{
    /**
     * @param string $className
     * @return Company
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'JobUp';
    }

    public function relations()
    {
        return [
            'Job' => [self::BELONGS_TO, '\job\models\Job', 'JobId'],
        ];
    }

    public function byJobId($jobId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."JobId" = :JobId';
        $criteria->params['JobId'] = $jobId;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    public function byActual($useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."StartTime" >= :Date';
        $criteria->params['Date'] = date('Y-m-d');
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}
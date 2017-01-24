<?php
namespace job\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $CategoryId
 * @property int $PositionId
 * @property string $Title
 * @property string $Text
 * @property string $Url
 * @property int $SalaryTo
 * @property int $SalaryFrom
 * @property string $CreationTime
 * @property bool $Visible
 *
 * @property Company $Company
 * @property Category $Category
 * @property Position $Position
 *
 * Описание вспомогательных методов
 * @method Job   with($condition = '')
 * @method Job   find($condition = '', $params = [])
 * @method Job   findByPk($pk, $condition = '', $params = [])
 * @method Job   findByAttributes($attributes, $condition = '', $params = [])
 * @method Job[] findAll($condition = '', $params = [])
 * @method Job[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Job byId(int $id, bool $useAnd = true)
 * @method Job byCompanyId(int $id, bool $useAnd = true)
 * @method Job byCategoryId(int $id, bool $useAnd = true)
 * @method Job byPositionId(int $id, bool $useAnd = true)
 * @method Job byTitle(string $title, bool $useAnd = true)
 * @method Job byUrl(string $url, bool $useAnd = true)
 * @method Job byVisible(bool $visible, bool $useAnd = true)
 */
class Job extends ActiveRecord
{
    /**
     * @param string $className
     * @return Job
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Job';
    }

    public function relations()
    {
        return [
            'Company' => [self::BELONGS_TO, '\job\models\Company', 'CompanyId'],
            'Category' => [self::BELONGS_TO, '\job\models\Category', 'CategoryId'],
            'Position' => [self::BELONGS_TO, '\job\models\Position', 'PositionId'],
        ];
    }

    /**
     *
     * @param string $companyName
     */
    public function setCompany($companyName)
    {
        $company = \job\models\Company::model()->byName($companyName)->find();
        if ($company == null) {
            $company = new \job\models\Company();
            $company->Name = $companyName;
            $company->save();
        }
        $this->CompanyId = $company->Id;
    }

    /**
     *
     * @param string $position
     */
    public function setPosition($positionTitle)
    {
        $position = \job\models\Position::model()->byTitle($positionTitle)->find();
        if ($position == null) {
            $position = new \job\models\Position();
            $position->Title = $positionTitle;
            $position->save();
        }
        $this->PositionId = $position->Id;
    }
}
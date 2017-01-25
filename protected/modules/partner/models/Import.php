<?php
namespace partner\models;

use api\models\Account;
use application\components\ActiveRecord;
use event\models\Event;

/**
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
 * @property Event $Event
 * @property ImportUser[] $Users
 *
 * Описание вспомогательных методов
 * @method Import   with($condition = '')
 * @method Import   find($condition = '', $params = [])
 * @method Import   findByPk($pk, $condition = '', $params = [])
 * @method Import   findByAttributes($attributes, $condition = '', $params = [])
 * @method Import[] findAll($condition = '', $params = [])
 * @method Import[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Import byId(int $id, bool $useAnd = true)
 * @method Import byEventId(int $id, bool $useAnd = true)
 * @method Import byVisible(bool $visible, bool $useAnd = true)
 */
class Import extends ActiveRecord
{
    /**
     * @var Account
     */
    private $apiAccount;

    /**
     * @var \PHPExcel_Worksheet Worksheet for the import excel file
     */
    private $worksheet;

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
        $path = \Yii::getPathOfAlias('partner.data.'.$this->EventId.'.import');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $path.DIRECTORY_SEPARATOR.$this->Id;
    }

    /**
     * Returns worksheet for the import excel file
     *
     * @return \PHPExcel_Worksheet
     * @throws \PHPExcel_Exception
     */
    public function getWorksheet()
    {
        if (is_null($this->worksheet)) {
            $phpExcel = \PHPExcel_IOFactory::load($this->getFileName());
            $this->worksheet = $phpExcel->getSheet(0);
        }

        return $this->worksheet;
    }

    /**
     * Returns significant columns
     *
     * @return string[]
     */
    public function getSignificantColumns()
    {
        if (!$worksheet = $this->getWorksheet()) {
            return [];
        }

        $result = [];
        foreach ($worksheet->getRowIterator(2) as $row) {
            /** @var $row \PHPExcel_Worksheet_Row */
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $cell) {
                /** @var $cell \PHPExcel_Cell */
                $value = trim($cell->getFormattedValue());
                if (!empty($value)) {
                    $result[] = $cell->getColumn();
                }
            }
        }

        $result = array_unique($result);
        sort($result, SORT_STRING);

        return $result;
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

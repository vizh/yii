<?php
namespace partner\models\forms\user;

use application\components\utility\Texts;
use event\models\Event;
use event\models\UserData;
use partner\models\Import;
use partner\models\ImportUser;

/**
 * Class ImportPrepare The model form for the preparation for the import
 */
class ImportPrepare extends \CFormModel
{
    // Column values
    const NO_IMPORT = 'NO_IMPORT';

    public $Notify = false;

    public $NotifyEvent = false;

    public $Visible = false;

    /**
     * @var string[] Column names
     */
    private $columns;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var array
     */
    private $values = [];

    private $attributeNames;

    private $columnValues;

    /**
     * @param Import $import
     * @param Event $event
     * @param string $scenario
     */
    public function __construct($import, $event, $scenario = '')
    {
        parent::__construct($scenario);

        $this->columns = $import->getSignificantColumns();
        $this->event = $event;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [implode(',', $this->attributeNames()), 'safe'],
            [implode(',', $this->columns), 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeNames()
    {
        if (is_null($this->attributeNames)) {
            $this->attributeNames = array_merge(parent::attributeNames(), $this->columns);
        }

        return $this->attributeNames;
    }

    /**
     * Returns column names
     * @return string[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Updates the import active record
     * @param Import $import
     * @return bool
     * @throws \CDbException
     * @throws \PHPExcel_Exception
     */
    public function updateImportActiveRecord(Import $import)
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $fields = array_filter($this->getAttributes($this->getColumns()), function ($v) {
                return $v !== self::NO_IMPORT;
            });
            $import->setAttributes(
                $this->getAttributes(['Notify', 'NotifyEvent', 'Visible']),
                false
            );
            $import->Fields = base64_encode(serialize($fields));
            $import->save();

            $worksheet = $import->getWorksheet();

            for ($i = 2; $i <= $worksheet->getHighestRow(); $i++) {
                $values = [];
                foreach ($this->columns as $column) {
                    $field = $this->$column;
                    if (!$field || $field === self::NO_IMPORT) {
                        continue;
                    }

                    $values[$this->$column] = Texts::clear($worksheet->getCell($column . $i)->getFormattedValue());
                }

                $this->createImportUser($import->Id, $values);
            }

            $transaction->commit();

            return true;
        } catch (\CDbException $e) {
            $transaction->rollback();
            return false;
        }
    }

    /**
     * Returns columns values that you can select for specified columns
     * @return array
     */
    public function getColumnValues()
    {
        if (is_null($this->columnValues)) {
            $this->columnValues = [
                self::NO_IMPORT => 'Не импортировать',
                'LastName' => 'Фамилия',
                'FirstName' => 'Имя',
                'FatherName' => 'Отчество',
                'LastName_en' => 'Фамилия (EN)',
                'FirstName_en' => 'Имя (EN)',
                'FatherName_en' => 'Отчество (EN)',
                'Email' => 'Email',
                'Phone' => 'Телефон',
                'Company' => 'Компания',
                'Company_en' => 'Компания (EN)',
                'Position' => 'Должность',
                'Role' => 'Статус',
                'Product' => 'Товар',
                'ExternalId' => 'Внешний ID',
                'PhotoUrl' => 'Ссылка на фото',
                'PhotoNameInPath' => 'Имя файла фото в папке (при импорте архива)'
            ];

            $userData = new UserData();
            $userData->EventId = $this->event->Id;
            foreach ($userData->getManager()->getDefinitions() as $definition) {
                $this->columnValues[$definition->name] = $definition->title;
            }
        }

        return $this->columnValues;
    }

    /**
     * Magic method __get
     * @param string $name
     * @return mixed|string
     * @throws \CException
     */
    public function __get($name)
    {
        if (in_array($name, $this->columns)) {
            return isset($this->values[$name]) ? $this->values[$name] : '';
        }

        return parent::__get($name);
    }

    /**
     * Magick method __set
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @throws \CException
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->columns)) {
            return $this->values[$name] = $value;
        }

        return parent::__set($name, $value);
    }

    /**
     * Magic method __isset
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        if (in_array($name, $this->columns)) {
            return isset($this->values[$name]);
        }

        return parent::__isset($name);
    }

    /**
     * Creates data for the user that will be imported
     * @param int $importId
     * @param array $values
     */
    private function createImportUser($importId, array $values)
    {
        $importUser = new ImportUser();
        $importUser->ImportId = $importId;

        $data = [];
        foreach ($values as $field => $value) {
            if ($importUser->hasAttribute($field)) {
                $importUser->$field = $value ?: null;
            } else {
                $data[$field] = $value;
            }
        }

        if (!empty($data)) {
            $importUser->UserData = json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        $importUser->save();
    }
}

<?php
namespace pay\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;

/**
 * @property int $Id
 * @property string $CreationTime
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
 */
class Import extends ActiveRecord
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
        return 'PayOrderImport';
    }

    public function relations()
    {
        return [
            'entries' => [self::HAS_MANY, ImportEntry::className(), 'ImportId', 'order' => 'entries."Id"']
        ];
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        $path = \Yii::getPathOfAlias('pay.data.import');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $path.DIRECTORY_SEPARATOR.$this->Id;
    }

    public function importOrders()
    {
        $file = $this->getFileName();
        $content = iconv('windows-1251', 'utf-8', file_get_contents($file));

        $lines = explode("\r\n", $content);
        $entries = [];
        $entry = null;
        foreach ($lines as $line) {
            if ($line == 'СекцияРасчСчет' || mb_strpos($line, 'СекцияДокумент') === 0) {
                $entry = [];
                continue;
            }
            if ($line == 'КонецРасчСчет' || $line == 'КонецДокумента') {
                $entries[] = $entry;
                $entry = null;
                continue;
            }
            if (is_array($entry)) {
                $keyvalue = explode('=', $line);
                if (count($keyvalue) != 2) {
                    continue;
                }
                list($key, $value) = $keyvalue;
                $entry[$key] = $value;
            }
        }

        //отфильтровать платежи - получатель = ООО "РУВЕНТС"
        $entries = array_filter($entries, function ($entry) {
            return ArrayHelper::getValue($entry, 'ПолучательИНН') == '7703806326';
        });

        $this->entries = array_map(function ($data) {
            $entry = new ImportEntry();
            $entry->ImportId = $this->Id;
            $entry->Data = $data;
            $entry->save();
            $entry->matchOrders();
        }, $entries);
    }
}

<?php
namespace pay\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;

/**
 * @property int $Id
 * @property int $OrderId
 * @property int $ImportId
 * @property string $OrderNumber
 * @property array $Data
 * @property bool $Approved
 *
 * Описание вспомогательных методов
 * @method ImportOrder   with($condition = '')
 * @method ImportOrder   find($condition = '', $params = [])
 * @method ImportOrder   findByPk($pk, $condition = '', $params = [])
 * @method ImportOrder   findByAttributes($attributes, $condition = '', $params = [])
 * @method ImportOrder[] findAll($condition = '', $params = [])
 * @method ImportOrder[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ImportOrder byId(int $id, bool $useAnd = true)
 * @method ImportOrder byOrderId(int $id, bool $useAnd = true)
 * @method ImportOrder byImportId(int $id, bool $useAnd = true)
 * @method ImportOrder byOrderNumber(string $number, bool $useAnd = true)
 * @method ImportOrder byApproved(bool $approved = true, bool $useAnd = true)
 */
class ImportOrder extends ActiveRecord
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
        return 'PayOrderImportOrder';
    }

    public function relations()
    {
        return [
            'order' => [self::BELONGS_TO, '\pay\models\Order', 'OrderId']
        ];
    }

    public function beforeSave()
    {
        $this->Data = serialize($this->Data);

        return parent::beforeSave();
    }

    public function afterSave()
    {
        $this->Data = unserialize($this->Data);
        parent::afterSave();
    }

    public function afterFind()
    {
        $this->Data = unserialize($this->Data);
        parent::afterFind();
    }

    public function matchOrder()
    {
        $this->OrderId = ArrayHelper::getValue($this->findOrder(), 'Id');
    }

    protected function findOrder()
    {
        $this->OrderNumber = $this->extractOrderNumber(ArrayHelper::getValue($this->Data, 'НазначениеПлатежа'));
        $orders = Order::model()->findAll('"Number" = :number', [':number' => $this->OrderNumber]);
        if (count($orders) == 1) {
            return $orders[0];
        }

        $split_number = explode('-', $this->OrderNumber);
        if (count($split_number) == 2) {
            $orders = Order::model()->findAll('"Number" = :number', [':number' => '-'.$split_number[1]]);
            if (count($orders) == 1) {
                return $orders[0];
            }
            $orders = Order::model()->findAll('"Number" = :number', [':number' => $split_number[1]]);
            if (count($orders) == 1) {
                return $orders[0];
            }
        }

        return null;
    }

    protected function extractOrderNumber($text)
    {
        $number = '';

        $matches = [];

        preg_match('/счета\s*[№|N]*\s*([а-яa-z0-9\-]*)/iu', $text, $matches);
        if (isset($matches[2]) && !empty($matches[2])) {
            $number = $matches[2];
        }

        if (!$number) {
            preg_match('/сч(е|ё)т[уа]*\s*[№|N]*\s*([а-яa-z0-9\-]*)/iu', $text, $matches);
            if (isset($matches[2]) && !empty($matches[2])) {
                $number = $matches[2];
            }
        }

        if (!$number) {
            preg_match('/сч\.*\s*[№|N]*\s*([а-яa-z0-9\-]*)/iu', $text, $matches);
            if (isset($matches[1]) && !empty($matches[1])) {
                $number = $matches[1];
            }
        }

        $replace = [
            'У' => 'Y',
            'К' => 'K',
            'Е' => 'E',
            'Н' => 'H',
            'Х' => 'X',
            'В' => 'B',
            'А' => 'A',
            'Р' => 'P',
            'О' => 'O',
            'С' => 'C',
            'М' => 'M',
            'Т' => 'T',
            '--' => '-'
        ];
        $number = strtr($number, $replace);

        return $number;
    }
}

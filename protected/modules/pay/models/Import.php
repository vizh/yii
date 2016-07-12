<?php
namespace pay\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;

/**
 * Class Import
 *
 * Fields
 * @property int $Id
 * @property string $CreationTime
 */
class Import extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PayOrderImport';
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, '\pay\models\ImportOrder', 'ImportId']
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

        return $path . DIRECTORY_SEPARATOR . $this->Id;
    }

    public function importOrders()
    {
        $file = $this->getFileName();
        $content = iconv('windows-1251', 'utf-8', file_get_contents($file));

        //разделить записи по пустым строкам
        $orders = explode("\r\n\r\n", $content);

        //разбить записи на массивы строк
        $orders = array_map(function ($order) {
            return explode("\r\n", $order);
        }, $orders);

        //разбить строки по "=" на пары ключ-значение
        $orders = array_map(function ($order) {
            $result = [];
            foreach ($order as $row) {
                $keyvalue = explode('=', $row);
                if (count($keyvalue) != 2) {
                    continue;
                }
                list($key, $value) = $keyvalue;
                $result[$key] = $value;
            }
            return $result;
        }, $orders);

        //отфильтровать платежи - получатель = ООО "РУВЕНТС"
        $orders = array_filter($orders, function ($order) {
            return ArrayHelper::getValue($order, 'ПолучательИНН') == '7703806326';
        });

        $this->orders = array_map(function($data){
            $order = new ImportOrder();
            $order->ImportId = $this->Id;
            $order->Data = $data;
            $order->matchOrder();
            $order->save();
        }, $orders);
    }
}

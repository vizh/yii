<?php
namespace partner\controllers\stat;

class PhysicalpayAction extends \partner\components\Action
{
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('Order.EventId = :EventId');
        $criteria->params = [
            'EventId' => \Yii::app()->partner->getAccount()->EventId
        ];
        $criteria->with = ['Order' => ['together' => true], 'Order.Items'];

        /** @var $logs \pay\models\PayLog[] */
        $logs = \pay\models\PayLog::model()->findAll($criteria);

        $calcItems = [];
        $sum = 0;
        foreach ($logs as $log) {
//      foreach ($log->Order->Items as $item)
//      {
//        if (!in_array($item->OrderItemId, $calcItems))
//        {
//          $calcItems[] = $item->OrderItemId;
//          $this->addLine($item, $log);
//        }
//      }
            $this->addLine(null, $log);
            $sum += $log->Total;
        }

        fclose($this->getFile());
    }

    /**
     * @param \pay\models\OrderItem $item
     * @param \pay\models\PayLog $log
     */
    private function addLine($item, $log)
    {
        //$result = array();
        //$result->

        fputcsv($this->getFile(), [$log->CreationTime, $log->OrderId, $log->Total, $log->PaySystem], ';');
    }

    private $filename;
    private $file;

    private function getFile()
    {
        if ($this->file == null) {
            if (empty($this->filename)) {
                $this->filename = 'physicalpay_'.date('Y-m-d_H-i-s').'.csv';
            }
            $this->file = fopen($this->getDataPath().$this->filename, 'w');
        }
        return $this->file;
    }

    private $dataPath;

    private function getDataPath()
    {
        if (empty($this->dataPath)) {
            $path = \Yii::getPathOfAlias('partner.data');
            $this->dataPath = $path.'/'.\Yii::app()->partner->getAccount()->EventId.'/stat/';
            if (!file_exists($this->dataPath)) {
                mkdir($this->dataPath, 0755, true);
            }
        }
        return $this->dataPath;
    }
}

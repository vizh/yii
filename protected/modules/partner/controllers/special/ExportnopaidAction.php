<?php
namespace partner\controllers\special;

class ExportnopaidAction extends \partner\components\Action
{
    public function run()
    {
        header("Content-Disposition: attachment;filename=export.csv");
        header("Content-Transfer-Encoding: binary");
        $criteria = new \CDbCriteria();
        $criteria->with = ['Payer', 'Owner', 'Product'];
        $items = \pay\models\OrderItem::model()->byEventId($this->getEvent()->Id)->byPaid(false)->byDeleted(false)->findAll();
        $file = fopen("php://output", 'w');
        foreach ($items as $item) {
            $fiedls = [
                \Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $item->CreationTime),
                $item->Product->Title,
                $item->Payer->RunetId,
                $item->Payer->getFullName(),
                $item->Payer->getEmploymentPrimary() !== null ? $item->Payer->getEmploymentPrimary()->Company->Name : '',
                $item->Payer->Email,
                $item->Payer->getContactPhone() !== null ? (string)$item->Payer->getContactPhone() : '',
                $item->Owner->RunetId,
                $item->Owner->getFullName(),
                $item->Owner->getEmploymentPrimary() !== null ? $item->Owner->getEmploymentPrimary()->Company->Name : '',
                $item->Owner->Email,
                $item->Owner->getContactPhone() !== null ? (string)$item->Owner->getContactPhone() : '',
            ];
            fputcsv($file, $fiedls, ';');
        }
    }
} 
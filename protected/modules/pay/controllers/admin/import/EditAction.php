<?php
namespace pay\controllers\admin\import;

use pay\models\ImportOrder;
use Yii;

class EditAction extends \pay\components\Action
{
    public function run($entryId)
    {
        /** @var $entry \pay\models\ImportEntry */
        $entry = \pay\models\ImportEntry::model()->findByPk($entryId);
        if (!$entry)
        {
            throw new \CHttpException(404, 'Не найден платеж с номером: ' . $entryId);
        }

        if (\Yii::app()->getRequest()->isPostRequest) {
            $data = $entry->Data;
            $data['НазначениеПлатежа'] = Yii::app()->request->getPost('value');
            $entry->Data = $data;
            $entry->save(false);
            ImportOrder::model()->deleteAllByAttributes(['EntryId' => $entry->Id]);
            $entry->matchOrders();
        }
        $this->getController()->redirect(\Yii::app()->createUrl('/pay/admin/import/result', ['id' => $entry->ImportId]));
    }
}

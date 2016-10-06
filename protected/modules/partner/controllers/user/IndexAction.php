<?php
namespace partner\controllers\user;


use application\modules\partner\models\search\Participant;
use partner\models\forms\user\RoleBulkChange;
use Yii;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $search = new Participant($this->getEvent());

        $bulkRoleChange = new RoleBulkChange();
        $bulkRoleChange->Event = $this->getEvent();
        if (Yii::app()->request->isPostRequest){
            $bulkRoleChange->setAttributes(
                Yii::app()->getRequest()->getParam('RoleBulkChange')
            );
            if ($bulkRoleChange->validate()){
                $bulkRoleChange->save();
                $this->getController()->redirect(['index']);
            }
        }

        $this->getController()->render('index', [
            'search' => $search,
            'event' => $this->getEvent(),
            'bulkRoleChange' => $bulkRoleChange
        ]);
    }
}
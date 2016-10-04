<?php
namespace partner\controllers\user;


use application\modules\partner\models\search\Participant;
use partner\models\forms\user\RoleBulkChange;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $search = new Participant($this->getEvent());

        $bulkRoleChange = new RoleBulkChange();
        if (\Yii::app()->request->isPostRequest){
            $bulkRoleChange->fillFromPost();
            if ($bulkRoleChange->save()){
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
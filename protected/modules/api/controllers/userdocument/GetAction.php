<?php

namespace api\controllers\userdocument;

use api\components\Action;
use api\components\Exception;
use user\models\Document;
use user\models\DocumentType;
use user\models\User;
use Yii;

class GetAction extends Action
{
    public function run()
    {
        $runetId = Yii::app()->getRequest()->getParam('RunetId', null);
        $documentTypeId = Yii::app()->getRequest()->getParam('DocumentTypeId', null);

        $documentType = DocumentType::model()->findByPk($documentTypeId);
        if ($documentType === null) {
            throw new Exception(1001, [$documentTypeId]);
        }

        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $document = Document::model()
            ->byUserId($user->Id)
            ->byTypeId($documentTypeId)
            ->byActual(true)
            ->find();

        if ($document === null) {
            throw new Exception(1000);
        }

        if ($document !== null) {
            $this->getDataBuilder()->createUser($user, []);
            $result = $this->getDataBuilder()->buildUserDocument($document);
            $this->setResult($result);
        }
    }
}

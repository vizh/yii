<?php
namespace api\controllers\userdocument;

use api\components\Exception;
use api\components\Action;
use user\models\Document;
use user\models\DocumentType;
use user\models\User;

class GetAction extends Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $documentTypeId = \Yii::app()->getRequest()->getParam('DocumentTypeId', null);

        $documentType = DocumentType::model()->findByPk($documentTypeId);
        if ($documentType === null) {
            throw new Exception(1001, array($documentTypeId));
        }

        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, array($runetId));
        }

        $document = Document::model()->byUserId($user->Id)->byTypeId($documentTypeId)->byActual(true)->find();
        if ($document !== null) {
            $this->getDataBuilder()->createUser($user);
            $result = $this->getDataBuilder()->buildUserDocument($document);
            $this->setResult($result);
        } else {
            throw new Exception(1000);
        }
    }
}
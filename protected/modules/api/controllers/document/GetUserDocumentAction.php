<?php
namespace api\controllers\document;

use api\components\Action;
use user\models\Document;
use user\models\DocumentType;
use user\models\User;

class GetUserDocumentAction extends Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $documentTypeId = \Yii::app()->getRequest()->getParam('DocumentTypeId', null);

        $documentType = DocumentType::model()->byId($documentTypeId)->find();
        $user = User::model()->byRunetId($runetId)->find();
        if ($documentType !== null) {
            if ($user !== null) {
                $document = Document::model()->byUserId($user->Id)->byTypeId($documentTypeId)->byActual(true)->find();
                if ($document !== null) {
                    $result = $this->getDataBuilder()->createUserDocument($document);
                    $this->setResult($result);
                } else {
                    throw new \api\components\Exception(1000);
                }
            } else {
                throw new \api\components\Exception(202, array($runetId));
            }
        } else {
            throw new \api\components\Exception(1001, array($documentTypeId));
        }
    }

}
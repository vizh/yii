<?php
namespace api\controllers\document;

use api\components\Action;
use user\models\DocumentType;

class GetDocumentTypeListAction extends Action
{
    public function run()
    {
        $documentTypes = DocumentType::model()->orderBy('"t"."Id"')->findAll();
        $result = [];
        foreach ($documentTypes as $documentType) {
            $result[] = $this->getDataBuilder()->createUserDocumentType($documentType);
        }
        $this->setResult($result);
    }
}
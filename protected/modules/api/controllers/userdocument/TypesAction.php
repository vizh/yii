<?php

namespace api\controllers\userdocument;

use api\components\Action;
use user\models\DocumentType;

class TypesAction extends Action
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

<?php
namespace api\controllers\pay;

use api\components\Exception;

class DeleteAction extends \api\components\Action
{
    public function run()
    {
        if ($this->getRequestedOrderItem()->delete() === false) {
            throw new Exception(412);
        }

        $this->setSuccessResult();
    }
}

<?php

use application\components\WebModule;

class PayModule extends WebModule
{
    /**
     * @inheritdoc
     */
    public function beforeControllerAction($controller, $action)
    {
        if ($action->getId() === 'return') {
            $this->csrfValidation = false;
        }

        return parent::beforeControllerAction($controller, $action);
    }
}


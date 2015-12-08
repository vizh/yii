<?php
namespace api\models\forms\user;

use application\components\form\CreateUpdateForm;
use user\models\User;

class Edit extends CreateUpdateForm
{
    /**
     * @inheritDoc
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }



}
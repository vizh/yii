<?php
namespace api\models\forms\user;

use api\components\Exception;
use application\components\form\CreateUpdateFormCombiner;
use CActiveRecord;
use user\models\forms\fields\Employment;
use user\models\forms\fields\Phone;
use user\models\User;

/**
 * Class Edit
 * @package api\models\forms\user
 *
 * @property string $Phone
 * @property string $Company
 * @property string $Position
 */
class Edit extends CreateUpdateFormCombiner
{
    /** @var User */
    protected $model;

    /**
     * @inheritDoc
     */
    public function __construct(User $model = null)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function fillFromPost()
    {
        foreach ($this->getAttributes() as $name => $value) {
            $param = \Yii::app()->getRequest()->getParam($name);
            if (!empty($param)) {
                $this->$name = \Yii::app()->getRequest()->getParam($name);
            }
        }
    }


    /**
     * @inheritDoc
     */
    protected function initForms()
    {
        $this->registerForm(Phone::className());
        $this->registerForm(Employment::className());
    }

    /**
     * @inheritDoc
     */
    public function validate($attributes = null, $clearErrors = true)
    {
        $valid = parent::validate($attributes, $clearErrors);
        if (!$valid) {
            foreach ($this->getErrors() as $attribute => $messages) {
                foreach ($messages as $message) {
                    throw new Exception(207, [$message]);
                }
            }
        }
        return true;
    }
}
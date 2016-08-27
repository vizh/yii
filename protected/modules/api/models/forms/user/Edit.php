<?php
namespace api\models\forms\user;

use api\components\Exception;
use application\components\form\CreateUpdateFormCombiner;
use CActiveRecord;
use user\models\forms\fields\Employment;
use user\models\forms\fields\Phone;
use user\models\User;
use Yii;

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

    public $Email;
    public $FirstName;
    public $LastName;
    public $FatherName;
    public $PrimaryPhone;

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
//        Yii::log(print_r($this->getAttributes(), true));
        foreach ($this->getAttributes() as $name => $value) {
            $param = Yii::app()->getRequest()->getParam($name);
            if ($param !== null) {
                $this->$name = $param;
            }
        }
    }

    public function rules()
    {
        return [
            ['FatherName, FirstName, LastName', 'safe'],
            ['Email', 'email'],
//            ['PrimaryPhone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
//            ['PrimaryPhone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone', 'criteria' => [
//                'condition' => '"t"."Id" != :UserId AND "t"."Visible"', 'params' => ['UserId' => $this->isUpdateMode() ? $this->model->Id : 0]]
//            ],
        ];
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

    /**
     * @inheritdoc
     */
    public function internalUpdateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->fillActiveRecord();
        $this->model->save();

        return $this->model;
    }
}
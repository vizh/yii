<?php
namespace connect\models\forms;

use application\components\form\CreateUpdateForm;
use connect\models\MeetingLinkUser;
use user\models\User;
use Yii;

class Signup extends CreateUpdateForm
{
    public $MeetingId;
    public $UserId;

    protected $User;

    public function rules()
    {
        return [
            ['MeetingId', 'required'],
            ['UserId', 'validateUser']
        ];
    }

    public function validateUser($attr, $params)
    {
        $this->User = User::model()->findByAttributes(['RunetId' => $this->UserId]);
        if (!$this->User) {
            $this->addError('UserId', 'Не найден пользователь с RUNET-ID: '.$this->UserId);
        }
    }

    /**
     * @return \CActiveRecord
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @inheritDoc
     */
    public function fillFromPost()
    {
        foreach ($this->getAttributes() as $name => $value) {
            $param = Yii::app()->getRequest()->getParam($name);
            if ($param !== null) {
                $this->$name = $param;
            }
        }
    }

    /**
     * Заполняет модель данными из формы
     * @return bool
     */
    protected function fillActiveRecord()
    {
        if (parent::fillActiveRecord()) {
            $this->model->Status = MeetingLinkUser::STATUS_ACCEPTED;
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->fillActiveRecord();
        return $this->model->save();
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        $this->model = new MeetingLinkUser();
        return $this->updateActiveRecord();
    }
}

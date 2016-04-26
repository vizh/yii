<?php
namespace api\components\ms\forms;

use api\models\forms\user\Register;
use event\models\UserData;

class BaseUser extends Register
{
    public $City;
    public $Country;
    public $Birthday;

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->Country = \Yii::app()->getRequest()->getParam('Country');
        $this->City = \Yii::app()->getRequest()->getParam('City');
        $this->Birthday = \Yii::app()->getRequest()->getParam('Birthday');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'Country' => 'Страна',
            'City' => 'Город',
            'Birthday' => 'Дата рождения'
        ]);
    }

    /**
     *
     */
    protected function saveUserData()
    {
        $data = new UserData();
        $data->EventId = $this->account->EventId;
        $data->CreatorId = $data->UserId = $this->model->Id;
        $manager = $data->getManager();
        $manager->City = $this->City;
        $manager->Country = $this->Country;
        $manager->Birthday = $this->Birthday;
        $data->save();
    }

    /**
     * @inheritdoc
     */
    protected function fillActiveRecord()
    {
        if (empty($this->model)) {
            return false;
        }
        foreach ($this->getAttributes() as $attr => $value) {
            if ($attr !== 'Birthday' && $this->isAttributeSafe($attr) && $this->model->hasAttribute($attr)) {
                $this->model->$attr = $value;
            }
        }
        return true;
    }
}
<?php
namespace api\components\ms\forms;

use api\models\forms\user\Register;
use event\models\UserData;

class BaseUser extends Register
{
    public $City;
    public $Country;

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->Country = \Yii::app()->getRequest()->getParam('Country');
        $this->City = \Yii::app()->getRequest()->getParam('City');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'Country' => 'Страна',
            'City' => 'Город'
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
        $data->save();
    }
}
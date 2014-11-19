<?php
namespace main\models\forms;

class CodeValidation extends \CFormModel
{
    private $eventId;

    public $code;

    public function __construct($eventId, $scenario = '')
    {
        parent::__construct($scenario);
        $this->eventId = $eventId;
    }

    public function rules()
    {
        return [
            ['code', 'required'],
            ['code', 'length', 'is' => 8],
            ['code', 'existUser']
        ];
    }

    public function existUser($attribute, $params)
    {
        if ($this->getUser() === null) {
            $this->addError($attribute, 'Пользователь с указанным кодом не найден.');
            return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Код участника'
        ];
    }


    private $apiAccount = null;

    /**
     * @throws \CHttpException
     * @return \api\models\Account
     */
    private function getApiAccount()
    {
        if ($this->apiAccount === null)
        {
            $this->apiAccount = \api\models\Account::model()->byEventId($this->eventId)->find();
            if ($this->apiAccount === null)
                throw new \CHttpException(500, "Не найден API аккаунт");
        }
        return $this->apiAccount;
    }

    private  $user = null;

    public function getUser()
    {
        if ($this->user === null)
        {
            $criteria = new \CDbCriteria();
            $criteria->addCondition('t."ExternalId" LIKE :Code');
            $criteria->params = ['Code' => strtolower($this->code) . '%'];

            $externalUser = \api\models\ExternalUser::model()
                ->byAccountId($this->getApiAccount()->Id)->find($criteria);

            if ($externalUser !== null && $externalUser->User !== null) {
                $this->user = $externalUser->User;
            }
        }
        return $this->user;
    }
}
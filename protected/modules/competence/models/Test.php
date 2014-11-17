<?php
namespace competence\models;

/**
 * Class Test
 * @package competence\models
 *
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property bool $Enable
 * @property bool $Test
 * @property string $Info
 * @property string $StartButtonText
 * @property bool $Multiple
 * @property string $EndTime
 * @property string $AfterEndText
 * @property bool $FastAuth
 * @property string $FastAuthSecret
 * @property int $EventId
 *
 * @property \event\models\Event $Event
 * @property Result[] $ResultsAll
 *
 * @method \competence\models\Test find($condition='',$params=array())
 * @method \competence\models\Test findByPk($pk,$condition='',$params=array())
 * @method \competence\models\Test[] findAll($condition='',$params=array())
 */
class Test extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Test
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CompetenceTest';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'ResultsAll' => [self::HAS_MANY, '\competence\models\Result', 'TestId']
        ];
    }

    /** @var \user\models\User */
    protected $user = null;

    /**
     * @param \user\models\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /** @var string  */
    protected  $userKey = null;

    public function getUserKey()
    {
        if ($this->FastAuth)
        {
            if ($this->userKey == null)
            {
                $userKey = $this->getUserKeyValue();
                $userHash = $this->getUserHashValue();
                if ($this->checkUserKeyHash($userKey, $userHash))
                {
                    $this->userKey = $userKey;
                    $request = \Yii::app()->getRequest();
                    if (!isset($request->cookies[$this->getUserKeyCookieName()]) || $request->cookies[$this->getUserKeyCookieName()]->value != $userKey)
                    {
                        $expire = time()+60*60*24*30;
                        \Yii::app()->request->cookies[$this->getUserKeyCookieName()] = new \CHttpCookie($this->getUserKeyCookieName(), $userKey, ['expire' => $expire]);
                        \Yii::app()->request->cookies[$this->getUserHashCookieName()] = new \CHttpCookie($this->getUserHashCookieName(), $userHash, ['expire' => $expire]);
                    }
                }
            }
            return $this->userKey;
        }
        return null;
    }

    private function getUserKeyCookieName()
    {
        return 'CompetenceUserKey'.$this->Id;
    }

    private function getUserHashCookieName()
    {
        return 'CompetenceUserHash'.$this->Id;
    }

    private function getUserKeyValue()
    {
        $request = \Yii::app()->getRequest();
        $userKey = $request->getParam('userKey');
        if (empty($userKey))
        {
            $userKey = isset($request->cookies[$this->getUserKeyCookieName()]) ? $request->cookies[$this->getUserKeyCookieName()]->value : substr(md5(microtime()), 0, 10);
        }
        return $userKey;
    }

    private function getUserHashValue()
    {
        $request = \Yii::app()->getRequest();
        $userHash = $request->getParam('userHash');
        if (empty($userHash))
        {
            $userHash = isset($request->cookies[$this->getUserHashCookieName()]) ? $request->cookies[$this->getUserHashCookieName()]->value : null;
        }
        return $userHash;
    }

    private function checkUserKeyHash($key, $hash = null)
    {
        if ($this->FastAuthSecret !== null)
        {
            return $hash == $this->getKeyHash($key);
        }
        else
            return true;
    }

    public function getKeyHash($key)
    {
        return md5($key.$this->FastAuthSecret);
    }


    protected $result = null;

    /**
     * @return Result|null
     * @throws \application\components\Exception
     */
    public function getResult()
    {
        if ($this->result === null)
        {
            if ($this->user === null && $this->getUserKey() === null)
                throw new \application\components\Exception('Для доступа к результату, необходимо сначала задать пользователя или ключ пользователя.');
            $model = Result::model()->byTestId($this->Id)->byFinished(false);
            if ($this->getUserKey() !== null)
            {
                $model->byUserKey($this->getUserKey());
            }
            else
            {
                $model->byUserId($this->user->Id);
            }
            $this->result = $model->find();
            if ($this->result === null)
            {
                $this->result = new Result();
                $this->result->TestId = $this->Id;
                $this->result->UserId = $this->user!==null ? $this->user->Id : null;
                $this->result->UserKey = $this->getUserKey();
                $this->result->setDataByResult([]);
                $this->result->save();
            }
        }
        return $this->result;
    }

    protected $firstQuestion = null;
    /**
     * @return Question
     */
    public function getFirstQuestion()
    {
        if ($this->firstQuestion === null)
        {
            $this->firstQuestion = \competence\models\Question::model()->byFirst()->byTestId($this->Id)->find();
            $this->firstQuestion->Test = $this;
        }
        return $this->firstQuestion;
    }

    public function getEndView()
    {
        $path = 'competence.views.tests.'.$this->Code;
        if (file_exists(\Yii::getPathOfAlias($path).DIRECTORY_SEPARATOR.'end.php'))
        {
            return $path . '.end';
        }
        return 'end';
    }

    public function saveResult()
    {
        $result = $this->getResult();
        $result->Finished = true;
        $result->save();
    }

    /**
     *
     * @param int $eventId
     * @param bool $useAnd
     * @return \competence\models\Test
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params['EventId'] = $eventId;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $code
     * @param bool $useAnd
     * @return $this
     */
    public function byCode($code, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Code" = :Code';
        $criteria->params['Code'] = $code;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     *
     * @param bool $enable
     * @param boll $useAnd
     * @return \competence\models\Test
     */
    public function byEnable($enable = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$enable ? 'NOT' : '').' "t"."Enable"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}
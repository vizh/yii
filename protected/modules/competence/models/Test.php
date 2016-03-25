<?php
namespace competence\models;

use application\components\ActiveRecord;
use application\components\Exception;
use event\models\Event;
use event\models\Role;
use user\models\User;

/**
 * Class Test
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
 * @property int $EventId The event identifier that test is related to
 * @property int $RoleIdAfterPass The role identifier that a user will get after passing the test
 * @property string $StartTime
 * @property string $BeforeText
 * @property string $AfterText
 * @property bool $ParticipantsOnly
 * @property bool $UseClearLayout
 * @property bool $RenderEventHeader
 *
 * @property Event $Event
 * @property Result[] $ResultsAll
 *
 * @method Test find($condition = '', $params = array())
 * @method Test findByPk($pk, $condition = '', $params = array())
 * @method Test[] findAll($condition = '', $params = array())
 * @method Test byParticipantsOnly(bool $participantsOnly)
 *
 */
class Test extends ActiveRecord
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $userKey;

    /**
     * @var mixed
     */
    protected $result;

    /**
     * @var Question The first question of the test
     */
    protected $firstQuestion;

    /**
     * @param string $className
     * @return Test
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'CompetenceTest';
    }

    /**
     * @inheritdoc
     */
    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'ResultsAll' => [self::HAS_MANY, '\competence\models\Result', 'TestId']
        ];
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUserKey()
    {
        if (!$this->FastAuth) {
            return null;
        }

        if (is_null($this->userKey)) {
            $userKey = $this->getUserKeyValue();
            $userHash = $this->getUserHashValue();

            if ($this->checkUserKeyHash($userKey, $userHash)) {
                $this->userKey = $userKey;
                $request = \Yii::app()->getRequest();

                if (!isset($request->cookies[$this->getUserKeyCookieName()]) || $request->cookies[$this->getUserKeyCookieName()]->value != $userKey) {
                    $expire = time() + 60 * 60 * 24 * 30;
                    \Yii::app()->request->cookies[$this->getUserKeyCookieName()] = new \CHttpCookie($this->getUserKeyCookieName(), $userKey, ['expire' => $expire]);
                    \Yii::app()->request->cookies[$this->getUserHashCookieName()] = new \CHttpCookie($this->getUserHashCookieName(), $userHash, ['expire' => $expire]);
                }
            }
        }

        return $this->userKey;
    }

    public function getKeyHash($key)
    {
        return md5($key . $this->FastAuthSecret);
    }

    /**
     * @return Result|null
     * @throws Exception
     */
    public function getResult()
    {
        if (is_null($this->result)) {
            if ($this->user === null && $this->getUserKey() === null) {
                throw new Exception('Для доступа к результату, необходимо сначала задать пользователя или ключ пользователя.');
            }

            $model = Result::model()->byTestId($this->Id)->byFinished(false);
            if ($this->getUserKey() !== null) {
                $model->byUserKey($this->getUserKey());
            } else {
                $model->byUserId($this->user->Id);
            }

            $this->result = $model->find();

            if ($this->result === null) {
                $this->result = new Result();
                $this->result->TestId = $this->Id;
                $this->result->UserId = $this->user !== null ? $this->user->Id : null;
                $this->result->UserKey = $this->getUserKey();
                $this->result->setDataByResult([]);
                $this->result->save();
            }
        }

        return $this->result;
    }

    /**
     * @return Question
     */
    public function getFirstQuestion()
    {
        if (is_null($this->firstQuestion)) {
            $this->firstQuestion = Question::model()->byFirst()->byTestId($this->Id)->find();
            $this->firstQuestion->Test = $this;
        }

        return $this->firstQuestion;
    }

    public function getEndView()
    {
        $path = 'competence.views.tests.' . $this->Code;
        if (file_exists(\Yii::getPathOfAlias($path) . DIRECTORY_SEPARATOR . 'done.php')) {
            return $path . '.done';
        }

        return 'done';
    }

    /**
     * Saves results
     * @throws Exception
     */
    public function saveResult()
    {
        $result = $this->getResult();
        $result->Finished = true;
        $result->save();

        $this->assignRole();
    }

    /**
     *
     * @param int $eventId
     * @param bool $useAnd
     * @return self
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
     * @return self
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
     * @param bool $useAnd
     * @return self
     */
    public function byEnable($enable = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$enable ? 'NOT' : '') . ' "t"."Enable"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * Assigns the specified in RoleIdAfterPass role to the user
     * @throws Exception
     */
    private function assignRole()
    {
        if (!$this->EventId || !$this->RoleIdAfterPass || !$this->user) {
            return;
        }

        $event = Event::model()->findByPk($this->EventId);
        $role = Role::model()->findByPk($this->RoleIdAfterPass);

        if (!empty($event->Parts)) {
            $event->registerUserOnAllParts($this->user, $role);
        } else {
            $event->registerUser($this->user, $role);
        }
    }

    private function getUserKeyCookieName()
    {
        return 'CompetenceUserKey' . $this->Id;
    }

    private function getUserHashCookieName()
    {
        return 'CompetenceUserHash' . $this->Id;
    }

    private function getUserKeyValue()
    {
        $request = \Yii::app()->getRequest();
        $userKey = $request->getParam('userKey');
        if (empty($userKey)) {
            $userKey = isset($request->cookies[$this->getUserKeyCookieName()]) ? $request->cookies[$this->getUserKeyCookieName()]->value : substr(md5(microtime()), 0, 10);
        }

        return $userKey;
    }

    private function getUserHashValue()
    {
        $request = \Yii::app()->getRequest();
        $userHash = $request->getParam('userHash');
        if (empty($userHash)) {
            $userHash = isset($request->cookies[$this->getUserHashCookieName()]) ? $request->cookies[$this->getUserHashCookieName()]->value : null;
        }

        return $userHash;
    }

    private function checkUserKeyHash($key, $hash = null)
    {
        return $this->FastAuthSecret ? $hash == $this->getKeyHash($key) : true;
    }
}

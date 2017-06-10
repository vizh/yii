<?php
namespace competence\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $TestId
 * @property int $UserId
 * @property string $Data
 * @property string $CreationTime
 * @property string $UpdateTime
 * @property bool $Finished
 * @property string $UserKey
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Result   with($condition = '')
 * @method Result   find($condition = '', $params = [])
 * @method Result   findByPk($pk, $condition = '', $params = [])
 * @method Result   findByAttributes($attributes, $condition = '', $params = [])
 * @method Result[] findAll($condition = '', $params = [])
 * @method Result[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Result byId(int $id, bool $useAnd = true)
 * @method Result byTestId(int $id, bool $useAnd = true)
 * @method Result byUserId(int $id, bool $useAnd = true)
 * @method Result byUserKey(string $key, bool $useAnd = true)
 * @method Result byFinished(bool $finished = true, bool $useAnd = true)
 */
class Result extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CompetenceResult';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Test' => [self::BELONGS_TO, '\competence\models\Test', 'TestId']
        ];
    }

    public function setDataByResult($result)
    {
        $this->result = $result;
        $this->Data = base64_encode(serialize($result));
    }

    protected $result;

    /**
     * @return array
     */
    public function getResultByData()
    {
        if ($this->result === null) {
            /** @noinspection UnserializeExploitsInspection */
            $this->result = unserialize(base64_decode($this->Data));
        }

        return $this->result;
    }

    /**
     * @param Question $question
     *
     * @return array
     */
    public function getQuestionResult(Question $question)
    {
        return isset($this->getResultByData()[$question->Code]) ? $this->getResultByData()[$question->Code] : [];
    }

    /**
     * @param Question $question
     * @param array $data
     */
    public function setQuestionResult(Question $question, $data)
    {
        $result = $this->getResultByData();
        $result[$question->Code] = $data;
        $this->setDataByResult($result);
    }

    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }

}
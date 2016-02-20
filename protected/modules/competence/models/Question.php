<?php
namespace competence\models;

use competence\models\form;
use application\components\Exception;

/**
 * Class Question
 *
 * Fields
 * @property int $Id
 * @property int $TestId
 * @property string $TypeId
 * @property string $Data
 * @property int $PrevQuestionId
 * @property int $NextQuestionId
 * @property string $Code
 * @property string $Title
 * @property string $SubTitle
 * @property boolean $First
 * @property boolean $Last
 * @property int $Sort
 * @property string $BeforeTitleText
 * @property string $AfterTitleText
 * @property string $AfterQuestionText
 * @property boolean $Required
 *
 * Relations
 * @property QuestionType $Type
 * @property Question $Prev
 * @property Question $Next
 *
 * @property Test $Test
 *
 * @method Question find($condition = '', $params = array())
 * @method Question findByPk($pk, $condition = '', $params = array())
 * @method Question[] findAll($condition = '', $params = array())
 *
 */
class Question extends \CActiveRecord
{
    protected $test;

    protected $formData;

    private $form;

    /**
     * @param string $className
     * @return Question
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
        return 'CompetenceQuestion';
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
            'Type' => [self::BELONGS_TO, 'competence\models\QuestionType', 'TypeId'],
            'Prev' => [self::BELONGS_TO, 'competence\models\Question', 'PrevQuestionId'],
            'Next' => [self::BELONGS_TO, 'competence\models\Question', 'NextQuestionId']
        ];
    }

    /**
     * @param bool $first
     * @param bool $useAnd
     * @return $this
     */
    public function byFirst($first = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$first ? 'NOT ' : '') . '"t"."First"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int $testId
     * @param bool $useAnd
     * @return $this
     */
    public function byTestId($testId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."TestId" = :TestId';
        $criteria->params = ['TestId' => $testId];
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
        $criteria->params = ['Code' => $code];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @return form\Base
     */
    public function getForm()
    {
        if (is_null($this->form)) {
            $className = "\\competence\\models\\test\\" . $this->Test->Code . "\\" . $this->Code;
            $this->form = new $className($this);
        }

        return $this->form;
    }

    /**
     * @return array|null
     */
    public function getFormData()
    {
        if (is_null($this->formData)) {
            $this->formData = $this->Data !== null ? unserialize(base64_decode($this->Data)) : [];
        }

        return $this->formData;
    }

    /**
     * @param array $data
     */
    public function setFormData($data)
    {
        $this->formData = $data;
        $this->Data = base64_encode(serialize($data));
    }

    public function setTest(Test $test)
    {
        if ($test->Id != $this->TestId) {
            throw new \application\components\Exception('Тест не соответствует данному вопросу');
        }

        $this->test = $test;
    }

    /**
     * Returns the current test
     * @return Test
     * @throws Exception
     */
    public function getTest()
    {
        if (is_null($this->test)) {
            throw new \application\components\Exception('Для вопроса не определен тест');
        }

        return $this->test;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        try {
            return $this->getTest()->getResult()->getQuestionResult($this);
        } catch (\application\components\Exception $e) {
            return null;
        }
    }

    protected function getFormPath()
    {
        return \Yii::getPathOfAlias('competence.models.test.' . $this->Test->Code . '.' . $this->Code) . '.php';
    }

    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $dataFile = \Yii::app()->getController()->renderPartial('competence.views.form.template', [
                'question' => $this,
                'test' => $this->Test
            ], true);
            file_put_contents($this->getFormPath(), $dataFile);
        }

        return parent::beforeSave();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Вопрос'),
            'SubTitle' => \Yii::t('app', 'Дополнительный текст к вопросу'),
            'BeforeTitleText' => \Yii::t('app', 'Текст перед вопросом'),
            'AfterTitleText' => \Yii::t('app', 'Текст после вопроса'),
            'AfterQuestionText' => \Yii::t('app', 'Текст после вариантов ответов'),
            'Required' => \Yii::t('app', 'Вопрос, обязательный для ответа')
        ];
    }
}

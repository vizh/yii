<?php
namespace competence\models;

use application\components\ActiveRecord;
use application\components\Exception;
use competence\models\form;

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
 * @property bool $First
 * @property bool $Last
 * @property int $Sort
 * @property string $BeforeTitleText
 * @property string $AfterTitleText
 * @property string $AfterQuestionText
 * @property bool $Required
 *
 * Relations
 * @property QuestionType $Type
 * @property Question $Prev
 * @property Question $Next
 *
 * @property Test $Test
 *
 * Описание вспомогательных методов
 * @method Question   with($condition = '')
 * @method Question   find($condition = '', $params = [])
 * @method Question   findByPk($pk, $condition = '', $params = [])
 * @method Question   findByAttributes($attributes, $condition = '', $params = [])
 * @method Question[] findAll($condition = '', $params = [])
 * @method Question[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Question byId(int $id, bool $useAnd = true)
 * @method Question byTestId(int $id, bool $useAnd = true)
 * @method Question byTypeId(int $id, bool $useAnd = true)
 * @method Question byPrevQuestionId(int $id, bool $useAnd = true)
 * @method Question byNextQuestionId(int $id, bool $useAnd = true)
 * @method Question byCode(string $code, bool $useAnd = true)
 * @method Question byTitle(string $title, bool $useAnd = true)
 * @method Question byFirst(bool $first, bool $useAnd = true)
 * @method Question byLast(bool $last, bool $useAnd = true)
 * @method Question byRequired(bool $required, bool $useAnd = true)
 */
class Question extends ActiveRecord
{
    protected $test;

    protected $formData;

    private $form;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
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
    public function relations()
    {
        return [
            'Type' => [self::BELONGS_TO, 'competence\models\QuestionType', 'TypeId'],
            'Prev' => [self::BELONGS_TO, 'competence\models\Question', 'PrevQuestionId'],
            'Next' => [self::BELONGS_TO, 'competence\models\Question', 'NextQuestionId']
        ];
    }

    /**
     * @return form\Base
     */
    public function getForm()
    {
        if (is_null($this->form)) {
            $className = "\\competence\\models\\test\\".$this->Test->Code."\\".$this->Code;
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
            /** @noinspection UnserializeExploitsInspection */
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
        return \Yii::getPathOfAlias('competence.models.test.'.$this->Test->Code.'.'.$this->Code).'.php';
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

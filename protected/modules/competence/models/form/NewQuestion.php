<?php
namespace competence\models\form;

class NewQuestion extends \CFormModel
{
    protected $test;

    public $Code;
    public $Type;

    public function __construct(\competence\models\Test $test, $scenario = '')
    {
        parent::__construct($scenario);
        $this->test = $test;
    }

    public function rules()
    {
        $criteriaCode = new \CDbCriteria();
        $criteriaCode->condition = '"t"."TestId" = :TestId';
        $criteriaCode->params = ['TestId' => $this->test->Id];
        return [
            ['Code', 'required'],
            ['Code', 'match', 'pattern' => '/^[A-Za-z][A-Za-z0-9_]*$/', 'message' => 'В поле код можно ипользовать только латиницу и цифры. Первым символом должна быть буква.'],
            ['Code', 'unique', 'attributeName' => 'Code', 'className' => '\competence\models\Question', 'criteria' => $criteriaCode],
            ['Type', 'exist', 'attributeName' => 'Id', 'className' => '\competence\models\QuestionType'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Code' => \Yii::t('app', 'Код '),
            'Type' => \Yii::t('app', 'Тип вопроса'),
        ];
    }

    /**
     * @return \competence\models\Question
     */
    public function createQuestion()
    {
        $question = new \competence\models\Question();
        $question->TestId = $this->test->Id;
        $question->TypeId = $this->Type;
        $question->Code = $this->Code;
        $maxQuestion = \competence\models\Question::model()
            ->byTestId($this->test->Id)->find(['order' => '"t"."Sort" DESC']);
        $question->Sort = ($maxQuestion != null ? $maxQuestion->Sort : 0) + 10;
        $question->Test = $this->test;
        $question->save();
        return $question;
    }

}
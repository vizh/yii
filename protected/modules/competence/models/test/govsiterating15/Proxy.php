<?php
namespace competence\models\test\govsiterating15;

use competence\models\form\Base;
use competence\models\Question;
use competence\models\Result;
use user\models\User;

class Proxy extends Base
{
    protected function getFormData()
    {
        return [
            'value' => \Yii::app()->getSession()->get(self::RATE_SITE_SESSION_NAME)
        ];
    }

    const RATE_SITE_SESSION_NAME = 'govsiterating15_rate_site';

    /**
     * @param Question $question
     * @param string $scenario
     */
    public function __construct($question, $scenario = '')
    {
        parent::__construct($question, $scenario);
        \Yii::app()->getSession()->add(static::RATE_SITE_SESSION_NAME, array_rand(static::getSiteList()));
    }

    /**
     * @return Question
     * @throws \application\components\Exception
     */
    public function getNext()
    {
        $key = \Yii::app()->getSession()->get(self::RATE_SITE_SESSION_NAME);
        /** @var User $user */
        $user = \Yii::app()->getUser()->getCurrentUser();

        $tests = [1,2,3];
        shuffle($tests);

        foreach ($tests as $qid) {
            $results = Result::model()->byTestId($this->question->getTest()->Id)->byUserId($user->Id)->byFinished(true)->findAll();
            foreach($results as $result) {
                $data = $result->getResultByData();
                if (!isset($data['Proxy']) || $data['Proxy']['value'] != $key) {
                    continue;
                }

                if (isset($data['Q1_'.$qid])) {
                    continue;
                }
            }
            $nextQuestion = Question::model()->byTestId($this->question->getTest()->Id)->byCode('Q1_' . $qid)->find();
            $nextQuestion->setTest($this->question->getTest());
            return $nextQuestion;
        }
    }

    /**
     *
     */
    public static function getRateSite()
    {
        $key = \Yii::app()->getSession()->get(self::RATE_SITE_SESSION_NAME);
        return static::getSiteList()[$key];
    }

    protected static function getSiteList()
    {
        return [
            1  => ['Федеральная миграционная служба', 'http://www.fms.gov.ru'],
            2  => ['Федеральное дорожное агентство', 'http://www.rosavtodor.ru'],
            3  => ['Федеральная служба судебных приставов', 'http://www.fssprus.ru'],
            4  => ['Министерство экономического развития Российской Федерации', 'http://economy.gov.ru'],
            5  => ['Федеральная служба по тарифам', 'http://www.fstrf.ru'],
            6  => ['Федеральная служба по интеллектуальной собственности', 'http://www.rupto.ru'],
            7  => ['Федеральная антимонопольная служба', 'http://www.fas.gov.ru'],
            8  => ['Министерство транспорта Российской Федерации', 'http://www.mintrans.ru'],
            9  => ['Министерство природных ресурсов и экологии Российской Федерации', 'http://www.mnr.gov.ru'],
            10 => ['Федеральная налоговая служба', 'http://www.nalog.ru'],
            11 => ['Федеральная служба по аккредитации', 'http://www.fsa.gov.ru'],
            12 => ['Федеральная служба по труду и занятости', 'http://www.rostrud.ru'],
            13 => ['Федеральная служба по надзору в сфере природопользования', 'http://rpn.gov.ru'],
            14 => ['Федеральная служба исполнения наказаний', 'http://www.fsin.su'],
            15 => ['Министерство здравоохранения Российской Федерации', 'http://www.rosminzdrav.ru'],
            16 => ['Федеральная служба по техническому и экспортному контролю', 'http://fstec.ru'],
            17 => ['Министерство культуры Российской Федерации', 'http://www.mkrf.ru'],
            18 => ['Федеральная служба по надзору в сфере защиты прав потребителей и благополучия человека', 'http://www.rospotrebnadzor.ru'],
            19 => ['Федеральная служба по гидрометеорологии и мониторингу окружающей среды', 'http://www.meteorf.ru'],
            20 => ['Федеральная таможенная служба', 'http://www.customs.ru']
        ];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        $user = \Yii::app()->getUser()->getCurrentUser();
        return 'Уважаемый '.$user->getFullName().'!';
    }

    /**
     * @inheritdoc
     */
    public function getBtnNextLabel()
    {
        return 'Перейти к опросу';
    }

    /**
     * @return array
     */
    protected function getInternalExportValueTitles()
    {
        return ['Cайт ФОИВ'];
    }

    /**
     * @param Result $result
     * @return array
     */
    protected function getInternalExportData(Result $result)
    {
        $data = $result->getQuestionResult($this->question);
        if (!empty($data) && is_numeric($data['value'])) {
            $site = static::getSiteList()[$data['value']];
            return [implode(', ', $site)];
        }
        return [];
    }


}

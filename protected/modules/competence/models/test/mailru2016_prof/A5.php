<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A5 extends \competence\models\form\Base
{

    protected function getBaseQuestionCode()
    {
        return 'A4';
    }

    protected $options = null;

    public function getOptions()
    {
        if ($this->options == null) {
            /** @var A4 $form */
            $form = $this->getBaseQuestion()->getForm();
            $result = $this->getBaseQuestion()->getResult();
            if ($result !== null) {
                $this->options = [];
                foreach ($form->getOptions() as $key => $value) {
                    if (in_array($key, $result['value'])) {
                        $this->options[$key] = $value;
                    }
                }
            }
        }
        return $this->options;
    }

    public function getE1Result()
    {
        $e1 = \competence\models\Question::model()->byTestId($this->question->TestId)->byCode('E1')->find();
        $e1->setTest($this->question->getTest());
        return $e1->getResult();
    }

    public $values = [
        1 => 'Печатные СМИ (общественно-политические: Ведомости, Коммерсантъ, Forbes и т.п.)',
        4 => 'Онлайн СМИ (интернет- издания или интернет-СМИ: Газета.ru, Lenta.ru, Slon.ru и т.п.)',
        5 => 'Западные медиа ( например,TechCrunch, Mashable, TheVerge, Vox и т.п.)',
        6 => 'Радио',
        7 => 'Телевидение',
        8 => 'Социальные сети (ВКонтакте, Facebook, Одноклассники, и т.п.)',
        9 => 'Социальные СМИ (Хабрахабр, Roem.ru, Цукерберг позвонит)',
        10 => 'Другое'
    ];

    public function rules()
    {
        return [
            ['value', 'checkAllValidator']
        ];
    }

    public function checkAllValidator($attribute, $params)
    {
        foreach ($this->getOptions() as $key => $value) {
            if (empty($this->value[$key])) {
                $this->addError('value', 'Необходимо указать источники информации для каждого из указанных людей.');
                return false;
            }
        }
        return true;
    }

    protected function getInternalExportValueTitles()
    {
        $titles = [
            40 => 'Гришин (Mail.Ru&nbsp;Group)',
            41 => 'Дуров (Telegram)',
            42 => 'Молибог (РБК)',
            43 => 'Пейдж (Alphabet, Google Global)',
            44 => 'Цукерберг (Facebook)',
            46 => 'Касперский (Касперский)',
            47 => 'Белоусов (Acronis, Parallels)',
            48 => 'Долгов (eBay)',
            401 => 'Артамонова Анна (Mail.Ru Group)',
            403 => 'Рогозов (ВКонтакте)',
            404 => 'Добродеев (Mail.Ru Group, ВКонтакте)',
            405 => 'Сергеев Дмитрий (Mail.Ru Group)',
            406 => 'Сатья Наделла (Microsoft)',
            407 => 'Федчин (Одноклассники)',
            408 => 'Соловьева (Google Россия)',
            409 => 'Шульгин (Яндекс)',
            410 => 'Волож (Яндекс)',
            411 => 'Касперская (InfoWatch)',
            412 => 'Брин (Google)',
            413 => 'Ян (ABBY)',
            49 => 'Затрудняюсь ответить'
        ];
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            40 => 'Гришин (Mail.Ru&nbsp;Group)',
            41 => 'Дуров (Telegram)',
            42 => 'Молибог (РБК)',
            43 => 'Пейдж (Alphabet, Google Global)',
            44 => 'Цукерберг (Facebook)',
            46 => 'Касперский (Касперский)',
            47 => 'Белоусов (Acronis, Parallels)',
            48 => 'Долгов (eBay)',
            401 => 'Артамонова Анна (Mail.Ru Group)',
            403 => 'Рогозов (ВКонтакте)',
            404 => 'Добродеев (Mail.Ru Group, ВКонтакте)',
            405 => 'Сергеев Дмитрий (Mail.Ru Group)',
            406 => 'Сатья Наделла (Microsoft)',
            407 => 'Федчин (Одноклассники)',
            408 => 'Соловьева (Google Россия)',
            409 => 'Шульгин (Яндекс)',
            410 => 'Волож (Яндекс)',
            411 => 'Касперская (InfoWatch)',
            412 => 'Брин (Google)',
            413 => 'Ян (ABBY)',
            49 => 'Затрудняюсь ответить'
        ];
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            if (!empty($questionData['value']) && isset($questionData['value'][$key])) {
                foreach ($questionData['value'][$key] as $i) {
                    $data[$key] .= $this->values[$i] . ';';
                }
            } else {
                $data[$key] = '';
            }
        }
        return $data;
    }
}

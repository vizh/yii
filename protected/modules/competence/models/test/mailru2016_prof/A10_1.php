<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A10_1 extends \competence\models\form\Base
{

    public $value = [];

    protected function getBaseQuestionCode()
    {
        return 'A10';
    }

    protected $options;

    public function getOptions()
    {
        if ($this->options == null) {
            /** @var A6 $form */
            $form = $this->getBaseQuestion()->getForm();
            $this->options = $form->getOptions();
        }
        return $this->options;
    }

    private $values;

    public function getValues()
    {
        if ($this->values === null) {
            $this->values = $this->rotate('A10_1_val', [
                10 => 'Полностью открытая, "прозрачная" компания',
                11 => 'Компания имеет хороший потенциал и перспективы развития',
                12 => 'Компания создает и развивает современные интернет-технологии',
                13 => 'Компания создает и развивает сервисы, которые пользуются большой популярностью',
                14 => 'У компании много лояльных пользователей',
                15 => 'Эта компания вызывает уважение',
                16 => 'У компании выстроены коммуникации с профессиональным сообществом',
                17 => 'Компания обладает сильными конкурентными преимуществами',
                18 => 'У компании выстроены коммуникации  с пользователями',
            ]);
        }
        return $this->values;
    }

    public function rules()
    {
        return [
            ['value', 'checkAllValidator']
        ];
    }

    public function checkAllValidator($attribute, $params)
    {
        foreach (self::getValues() as $key => $value) {
            if (empty($this->value[$key])) {
                $this->addError('value', 'Для каждого из высказываний необходимо выбрать хотя бы один подходящий вариант.');
                return false;
            }
        }
        return true;
    }

    protected function getDefinedViewPath()
    {
        return "competence.views.test." . $this->question->Test->Code . ".a10";
    }

    protected function getInternalExportValueTitles()
    {
        $titles = [
            10 => 'Полностью открытая, "прозрачная" компания',
            11 => 'Компания имеет хороший потенциал и перспективы развития',
            12 => 'Компания создает и развивает современные интернет-технологии',
            13 => 'Компания создает и развивает сервисы, которые пользуются большой популярностью',
            14 => 'У компании много лояльных пользователей',
            15 => 'Эта компания вызывает уважение',
            16 => 'У компании выстроены коммуникации с профессиональным сообществом',
            17 => 'Компания обладает сильными конкурентными преимуществами',
            18 => 'У компании выстроены коммуникации  с пользователями',
        ];
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            10 => 'Полностью открытая, "прозрачная" компания',
            11 => 'Компания имеет хороший потенциал и перспективы развития',
            12 => 'Компания создает и развивает современные интернет-технологии',
            13 => 'Компания создает и развивает сервисы, которые пользуются большой популярностью',
            14 => 'У компании много лояльных пользователей',
            15 => 'Эта компания вызывает уважение',
            16 => 'У компании выстроены коммуникации с профессиональным сообществом',
            17 => 'Компания обладает сильными конкурентными преимуществами',
            18 => 'У компании выстроены коммуникации  с пользователями',
        ];
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            $data[] = isset($questionData['value'][$key]) ? implode(',', $questionData['value'][$key]) : '';
        }
        return $data;
    }
}

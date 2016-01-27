<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A4 extends \competence\models\form\Base {

    public $value = [];

    private $options = null;
    public function getOptions()
    {
        if ($this->options === null)
        {
            $this->options = $this->rotate('A4_opt', [
                40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
                41 => '<strong>Дуров</strong> (<em>Telegram</em>)',
                404 => '<strong>Добродеев</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
                403 => '<strong>Рогозов</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
                405 => '<strong>Сергеев Дмитрий</strong> (<em>Mail.Ru Group</em>)',
                42 => '<strong>Молибог</strong> (<em>РБК</em>)',
                43 => '<strong>Пейдж</strong> (<em>Alphabet, Google Global</em>)',
                44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
                406 => '<strong>Сатья Наделла</strong> (<em>Microsoft</em>)',
                46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
                47 => '<strong>Белоусов</strong> (<em>Acronis, Parallels</em>)',
                408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
                48 => '<strong>Долгов</strong> (<em>eBay</em>)',
                407 => '<strong>Федчин</strong> (<em>Mail.Ru Group, Одноклассники</em>)',
                409 => '<strong>Шульгин</strong> (<em>Яндекс</em>)',
                401 => '<strong>Артамонова Анна</strong> (<em>Mail.Ru Group</em>)'
            ]);
        }
        return $this->options;
    }

    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Отметьте, о ком вы слышали, или выберите вариант затрудняюсь ответить.']
        ];
    }

    public function getPrev()
    {
        $e1 = $this->getQuestionByCode('E1');
        if (in_array(99, $e1->getResult()['value']))
        {
            return $e1;
        }
        else
        {
            $e1_1 = $this->getQuestionByCode('E1_1');
            if (in_array(99, $e1_1->getResult()['value']))
            {
                return $e1_1;
            }
        }
        return parent::getPrev();
    }


    public function getNext()
    {
        if (in_array(99, $this->value))
        {
            return $this->getQuestionByCode('A6');
        }
        return parent::getNext();
    }

    protected function getInternalExportValueTitles()
    {
        $titles = [
            40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
            41 => '<strong>Дуров</strong> (<em>Telegram</em>)',
            404 => '<strong>Добродеев</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            403 => '<strong>Рогозов</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            405 => '<strong>Сергеев Дмитрий</strong> (<em>Mail.Ru Group</em>)',
            42 => '<strong>Молибог</strong> (<em>РБК</em>)',
            43 => '<strong>Пейдж</strong> (<em>Alphabet, Google Global</em>)',
            44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
            406 => '<strong>Сатья Наделла</strong> (<em>Microsoft</em>)',
            46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
            47 => '<strong>Белоусов</strong> (<em>Acronis, Parallels</em>)',
            408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
            48 => '<strong>Долгов</strong> (<em>eBay</em>)',
            407 => '<strong>Федчин</strong> (<em>Mail.Ru Group, Одноклассники</em>)',
            409 => '<strong>Шульгин</strong> (<em>Яндекс</em>)',
            401 => '<strong>Артамонова Анна</strong> (<em>Mail.Ru Group</em>)'
        ];
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
            41 => '<strong>Дуров</strong> (<em>Telegram</em>)',
            404 => '<strong>Добродеев</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            403 => '<strong>Рогозов</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            405 => '<strong>Сергеев Дмитрий</strong> (<em>Mail.Ru Group</em>)',
            42 => '<strong>Молибог</strong> (<em>РБК</em>)',
            43 => '<strong>Пейдж</strong> (<em>Alphabet, Google Global</em>)',
            44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
            406 => '<strong>Сатья Наделла</strong> (<em>Microsoft</em>)',
            46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
            47 => '<strong>Белоусов</strong> (<em>Acronis, Parallels</em>)',
            408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
            48 => '<strong>Долгов</strong> (<em>eBay</em>)',
            407 => '<strong>Федчин</strong> (<em>Mail.Ru Group, Одноклассники</em>)',
            409 => '<strong>Шульгин</strong> (<em>Яндекс</em>)',
            401 => '<strong>Артамонова Анна</strong> (<em>Mail.Ru Group</em>)'
        ];
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            $data[] = !empty($questionData['value']) && in_array($key, $questionData['value']) ? 1 : '';
        }

        return $data;
    }
}

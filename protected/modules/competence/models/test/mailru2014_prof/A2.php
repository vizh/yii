<?php
namespace competence\models\test\mailru2014_prof;

use competence\models\Result;

class A2 extends \competence\models\form\Base {
  protected function getBaseQuestionCode()
  {
    return 'A1';
  }

  protected $options = null;

  public function getOptions()
  {
    if ($this->options == null)
    {
      /** @var A1 $form */
      $form = $this->getBaseQuestion()->getForm();
      $result = $this->getBaseQuestion()->getResult();
      if ($result !== null)
      {
        $this->options = [];
        foreach ($form->getOptions() as $key => $value)
        {
          if (isset($result['value'][$key]))
          {
            $this->options[$key] = $value;
          }
        }
      }
    }

    return $this->options;
  }

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    foreach ($this->getOptions() as $key => $value)
    {
      if ((empty($this->value[$key]['Company']) && empty($this->value[$key]['CompanyEmpty'])) || (empty($this->value[$key]['LastName']) && empty($this->value[$key]['LastNameEmpty'])))
      {
        $this->addError('value', 'Необходимо заполнить все значения фамилии и компании, или отметить вариант "затрудняюсь ответить".');
        return false;
      }
    }
    return true;
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

    protected function getInternalExportValueTitles()
    {
        $titles = [
            39 . ' - Фамилия', 39 . ' - Компания',
            40 . ' - Фамилия', 40 . ' - Компания',
            41 . ' - Фамилия', 41 . ' - Компания',
            42 . ' - Фамилия', 42 . ' - Компания',
            43 . ' - Фамилия', 43 . ' - Компания',
            44 . ' - Фамилия', 44 . ' - Компания',
            45 . ' - Фамилия', 45 . ' - Компания',
            46 . ' - Фамилия', 46 . ' - Компания',
            47 . ' - Фамилия', 47 . ' - Компания',
            48 . ' - Фамилия', 48 . ' - Компания',
            400 . ' - Фамилия', 400 . ' - Компания',
            401 . ' - Фамилия', 401 . ' - Компания',
            403 . ' - Фамилия', 403 . ' - Компания',
            404 . ' - Фамилия', 404 . ' - Компания',
            405 . ' - Фамилия', 405 . ' - Компания',
            406 . ' - Фамилия', 406 . ' - Компания',
            407 . ' - Фамилия', 407 . ' - Компания',
            408 . ' - Фамилия', 408 . ' - Компания',
            409 . ' - Фамилия', 409 . ' - Компания'
        ];
        return $titles;
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 400, 401, 403, 404, 405, 406, 407, 408, 409
        ];
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($titles as $key) {
            if (isset($questionData['value'][$key]['LastName'])) {
                $data[] = $questionData['value'][$key]['LastName'];
            } elseif (isset($questionData['value'][$key]['LastNameEmpty'])) {
                $data[] = 'не знаю';
            } else {
                $data[] = '';
            }

            if (isset($questionData['value'][$key]['Company'])) {
                $data[] = $questionData['value'][$key]['Company'];
            } elseif (isset($questionData['value'][$key]['CompanyEmpty'])) {
                $data[] = 'не знаю';
            } else {
                $data[] = '';
            }
        }
        return $data;
    }
}

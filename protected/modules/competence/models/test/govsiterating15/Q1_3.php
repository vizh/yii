<?php
namespace competence\models\test\govsiterating15;

class Q1_3 extends \competence\models\form\Base
{
    public function getTitle()
    {
        $site = Proxy::getRateSite();
        $title  = '
            Посетите сайт "<a href="'. $site[1] .'" target="_blank">'. $site[0] .'</a>". Ознакомьтесь с его содержанием.
            <div class="row m-top_10 m-bottom_60">
                <div class="text-center span8">
                    <a class="btn" style="font-weight: normal;" href="http://www.fas.gov.ru" target="_blank">ПЕРЕЙТИ НА САЙТ ФОИВ</a>
                </div>
            </div>
        ';
        $title .= parent::getTitle();
        return $title;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function validateValue($attribute)
    {
        $value = $this->$attribute;
        $valid = true;
        foreach ($this->getPairValues() as $key => $pair) {
            if (empty($value[$key]) || !in_array($value[$key], [1,2])) {
                $valid = false;
                break;
            }
        }

        if (!$valid) {
            $this->addError($attribute, 'Выберите значение во всех парах определений, характеризующих сайт');
        }
        return $valid;
    }


    public function getPairValues()
    {
        return [
            [1 => 'Устаревший', 2 => 'Современный'],
            [1 => 'Эффективный', 2 => 'Неэффективный'],
            [1 => 'Неудобный', 2 => 'Удобный'],
            [1 => 'Чистый', 2 => 'Замусоренный'],
            [1 => 'Привлекательный', 2 => 'Непривлекательный'],
            [1 => 'Любительский', 2 => 'Профессиональный'],
            [1 => 'Скучный', 2 => 'Интересный'],
            [1 => 'Бесполезный', 2 => 'Полезный'],
            [1 => 'Качественный', 2 => 'Халтурный'],
            [1 => 'Сложный', 2 => 'Простой'],
            [1 => 'Дружественный', 2 => 'Недружественный'],
            [1 => 'Раздражающий', 2 => 'Комфортабельный'],
            [1 => 'Прямой', 2 => 'Запутанный'],
            [1 => 'Головоломный', 2 => 'Интуитивный'],
            [1 => 'Содержательный', 2 => 'Пустой']
        ];
    }

    public function getPrev()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getBtnNextLabel()
    {
        return 'Отправить результаты';
    }
}

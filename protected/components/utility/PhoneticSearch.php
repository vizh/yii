<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.07.2015
 * Time: 13:10
 */

namespace application\components\utility;

/**
 * Class PhoneticSearch
 *
 * Класс для формирования индекса, используемого для фонетического поиска
 * @package application\components\utility
 */
class PhoneticSearch
{
    const LANG_RU = 'ru';
    const LANG_EN = 'en';

    /** @var array */
    private static $ALPHABET_RU = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','м','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я'];

    /** @var array согласные русского алфавита  */
    private static $CONSONANTS_RU = ['б','в','г','д','ж','з','й','к','п','с','т','ф','х','ц','ч','ш','щ'];

    /**
     * Возвращает фонетический индкс для входной строки
     * @param string $string входная строка
     * @return string
     */
    public static function getIndex($string)
    {
        $result = [];
        $strings = self::prepareString($string);
        $lang = self::getLang($strings);

        $strings = self::prepareString($string);
        foreach ($strings as $string) {
            $result[] = ($lang === self::LANG_RU ? self::getRuIndex($string) : $string);

        }
        return implode(' ', $result);
    }

    /**
     * @param $string
     * @return array
     */
    private static function prepareString($string)
    {
        $result = [];
        $string = mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
        $string = str_replace('-', ' ', $string);
        foreach (explode(' ', $string) as $part) {
            $part = preg_replace('/\W+/u', '', $part);
            $part = trim($part);
            if (!empty($part)) {
                $result[] = $part;
            }
        }
        return $result;
    }

    /**
     * Возвращает фонетический индкс для входной строки на русском языке
     * @param string $string
     * @return string
     */
    private static function getRuIndex($string)
    {
        $result = self::clearDuplicateChars($string);

        $replace = [
            'йо' => 'и',
            'ио' => 'и',
            'йе' => 'и',
            'ие' => 'и',
            'о'  => 'а',
            'ы'  => 'а',
            'я'  => 'а',
            'е'  => 'и',
            'ё'  => 'и',
            'э'  => 'и',
            'ю'  => 'у'
        ];
        $result = strtr($result, $replace);

        $replace = [
            'б' => 'п',
            'з' => 'с',
            'д' => 'т',
            'в' => 'ф',
            'г' => 'к'
        ];

        $patternConsonants = '(' . implode('|', self::$CONSONANTS_RU) . ')';
        foreach ($replace as $from => $to) {
            $result = preg_replace('/' . $from . $patternConsonants . '/u', $to . '$1', $result);
            $result = preg_replace('/' . $from . '$/u', $to, $result);
        }

        $result = self::clearDuplicateChars($result);

        $replace = [
            'ъ' => '',
            'ь' => '',
            'тс' => 'ц',
            'дс' => 'ц'
        ];
        $result = strtr($result, $replace);
        return $result;
    }

    /**
     * Определяет язык входной строки
     * @param array $strings
     * @return string
     */
    private static function getLang($strings)
    {
        if (isset($strings[0])) {
            foreach (self::$ALPHABET_RU as $char) {
                if (strpos($strings[0], $char) !== false) {
                    return self::LANG_RU;
                }
            }
        }
        return self::LANG_EN;
    }

    /**
     * @param $string
     * @return mixed
     */
    private static function clearDuplicateChars($string)
    {
        foreach (self::$ALPHABET_RU as $char) {
            $string = preg_replace('/' . $char . '{2,}/u', $char, $string);
        }
        return $string;
    }
}
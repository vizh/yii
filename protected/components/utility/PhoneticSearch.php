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
    /** @var array */
    private static $ALPHABET_RU = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','м','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я'];

    /** @var array согласные русского алфавита  */
    private static $CONSONANTS_RU = ['б','в','г','д','ж','з','й','к','п','с','т','ф','х','ц','ч','ш','щ'];

    public static function getIndex($string)
    {
        $result = trim($string);

        $result = self::clearDuplicateChars($result);

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

        $pairs = [];
        foreach ($replace as $from => $to) {
            foreach (self::$CONSONANTS_RU as $char) {
                $pairs[($from . $char)] = ($to . $char);
                $pairs[($char . $from)] = ($char . $to);
            }
        }
        $result = strtr($result, $pairs);

        $result = self::clearDuplicateChars($result);
        $replace = [
            'евская' => '%',
            'овская' => '$',
            'евский' => '#',
            'овский' => '@',
            'ова' => '9',
            'ева' => '9',
            'ин' => '8',
            'ий' => '7',
            'ый' => '7',
            'ая' => '6',
            'ых' => '5',
            'их' => '5',
            'ов' => '4',
            'ев' => '4',
            'нко' => '3',
            'ик' => '2',
            'ек' => '2',
            'ина' => '1',
            'ук' => '0',
            'юк' => '0'
        ];
        foreach ($replace as $from => $to) {
            $result = preg_replace('/' . $from . '$/u', $to, $result);
        }

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
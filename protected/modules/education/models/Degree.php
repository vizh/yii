<?php
namespace education\models;

/**
 * Class Degree Инкапсулирует степени высшего образования
 *
 * @package education\models
 */
final class Degree
{
    const BACHELOR = 'bachelor';
    const MASTER = 'master';
    const SPECIALIST = 'specialist';
    const CANDIDATE = 'candidate';
    const DOCTOR = 'doctor';

    /**
     * Возвращает массив всех степеней с названиями
     *
     * @return array
     */
    public static function getAll()
    {
        return [
            self::BACHELOR => 'Бакалавр',
            self::MASTER => 'Магистр',
            self::SPECIALIST => 'Специалист',
            self::CANDIDATE => 'Кандидат наук',
            self::DOCTOR => 'Доктор наук'
        ];
    }
}
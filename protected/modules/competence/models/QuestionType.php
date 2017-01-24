<?php
namespace competence\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Class
 * @property string $Title
 * @property string $Description
 *
 * Описание вспомогательных методов
 * @method QuestionType   with($condition = '')
 * @method QuestionType   find($condition = '', $params = [])
 * @method QuestionType   findByPk($pk, $condition = '', $params = [])
 * @method QuestionType   findByAttributes($attributes, $condition = '', $params = [])
 * @method QuestionType[] findAll($condition = '', $params = [])
 * @method QuestionType[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method QuestionType byId(int $id, bool $useAnd = true)
 * @method QuestionType byClass(string $class, bool $useAnd = true)
 */
class QuestionType extends ActiveRecord
{
    /**
     * @param string $className
     * @return QuestionType
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CompetenceQuestionType';
    }
}
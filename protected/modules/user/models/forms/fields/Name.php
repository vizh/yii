<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 07.12.2015
 * Time: 15:20
 */

namespace user\models\forms\fields;

use application\components\form\FormModel;

/**
 * Class Name
 * @package user\models\forms\fields
 *
 * Редактивует ФИО
 */
class Name extends FormModel
{
    /** @var string Имя */
    public $FirstName;

    /** @var string Фамилия */
    public $LastName;

    /** @var string Отчество */
    public $FatherName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['FirstName,LastName,FatherName', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['FirstName, LastName', 'required'],
            ['FatherName', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'FirstName' => \Yii::t('app', 'Имя'),
            'LastName' => \Yii::t('app', 'Фамилия'),
            'FatherName' => \Yii::t('app', 'Отчество')
        ];
    }
}
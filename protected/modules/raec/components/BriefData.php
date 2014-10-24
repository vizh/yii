<?php
namespace raec\components;

use application\components\attribute\JsonContainer;
use company\models\Company;
use raec\models\Brief;
use user\models\User;

/**
 * Class BriefData
 * @package raec\components
 *
 * @property string $CompanyLabel
 */
class BriefData extends \CFormModel{
    use JsonContainer;

    /**
     * @param Brief $model
     */
    public function __construct(Brief $model)
    {
        $this->initJsonContainer($model);
    }

    /**
     * Имя json-поля модели, для хранения данных
     * @return string
     */
    protected function containerName()
    {
        return 'Data';
    }

    /**
     * Описание хранимых в контейнере аттрибутов.
     * Возможны 2 способа задания:
     * 1. ['Name1', 'Name2', ...] - список имен хранимых полей. В данном случае все поля
     * определяют объекты класса Definition
     * 2. [['Name', 'DefinitionClass', 'GroupId', ...params], ...] - каждое хранимое поле определяется тем классом,
     * который был указан после имени поля. Также возможно задать дополнительные параметры,
     * соответствующие DefinitionClass.
     * @return string[]|array
     */
    protected function attributeDefinitions()
    {
        return [
            'CompanyId',
            ['CompanyLabel', 'Definition', 0, 'title' => \Yii::t('app', 'Компания')],
            ['CompanySynonyms', 'ModelListDefinition', 0, 'title' => \Yii::t('app', 'Дочерние компании'), 'className' => '\company\models\Company',
                'attributeName' => function (\CActiveRecord $model, $data) {
                    $company = $model->findByPk($data['Id']);
                    return $company;
                },
                'valueAttributeName' => 'Name'
            ],
            ['CEOFirstName', 'Definition', 0, 'title' => \Yii::t('app', 'Имя руководителя')],
            ['CEOLastName', 'Definition', 0, 'title' => \Yii::t('app', 'Фамилия руководителя')],
            ['CEOFatherName', 'Definition', 0, 'title' => \Yii::t('app', 'Отчество руководителя')],
            ['CEOPosition', 'Definition', 0, 'title' => \Yii::t('app', 'Должность руководителя')],
            ['CEOPositionBase', 'Definition', 0, 'title' => \Yii::t('app', 'Основание назначения руководителя')],
            ['BookerFirstName', 'Definition', 0, 'title' => \Yii::t('app', 'Имя главного бухгалтера')],
            ['BookerLastName', 'Definition', 0, 'title' => \Yii::t('app', 'Фамилия главного бухгалтера')],
            ['BookerFatherName', 'Definition', 0, 'title' => \Yii::t('app', 'Отчество главного бухгалтера')],
            ['JuridicalOPF', 'Definition', 0, 'title' => \Yii::t('app', 'Тип')],
            ['JuridicalShortName', 'Definition', 0, 'title' => \Yii::t('app', 'Краткое наименование')],
            ['JuridicalFullName', 'Definition', 0, 'title' => \Yii::t('app', 'Полное наименование')],
            ['JuridicalAddress', 'Definition', 0, 'title' => \Yii::t('app', 'Юридический адрес')],
            ['JuridicalAddressActual', 'Definition', 0, 'title' => \Yii::t('app', 'Фактический адрес')],
            ['JurudicalINN', 'Definition', 0, 'title' => \Yii::t('app', 'ИНН')],
            ['JurudicalOGRN', 'Definition', 0, 'title' => \Yii::t('app', 'ОГРН')],
            ['JurudicalOGRNDate', 'Definition', 0, 'title' => \Yii::t('app', 'Дата ОГРН')],
            ['JurudicalBIK', 'Definition', 0, 'title' => \Yii::t('app', 'БИК')],
            ['JuridicalKPP', 'Definition', 0, 'title' => \Yii::t('app', 'КПП')],
            ['JuridicalBankName', 'Definition', 0, 'title' => \Yii::t('app', 'Наименование банка')],
            ['JurudicalAccount', 'Definition', 0, 'title' => \Yii::t('app', 'Расчетный счет')],
            ['JurudicalCorrAccount', 'Definition', 0, 'title' => \Yii::t('app', 'Корреспондентский счет')],
            ['JuridicalAddressEqual', 'Definition', 0, 'title' => \Yii::t('app', 'Совпадает с юридическим')],
            ['Year', 'Definition', 0, 'title' => \Yii::t('app', 'Год основания')],
            ['ProfessionalInterest', 'ModelListDefinition', 0, 'title' => \Yii::t('app', 'Cфера деятельности'),  'className' => '\application\models\ProfessionalInterest', 'valueAttributeName' => 'Title'],
            ['Progress', 'Definition', 0, 'title' => \Yii::t('app', 'Главные достижения')],
            ['Employees', 'Definition', 0, 'title' => \Yii::t('app', 'Информация о коллективе и руководстве')],
            ['Customers', 'Definition', 0, 'title' => \Yii::t('app', 'Информация о клиентах')],
            ['Additional', 'Definition', 0, 'title' => \Yii::t('app', 'Дополнительная информация')],
            ['Users', 'ModelListDefinition', 0, 'title' => \Yii::t('app', 'Представители организации'), 'className' => '\user\models\User',
               'attributeName' => function (\CActiveRecord $model, $data) {
                    if (!isset($data['RunetId'])) {
                        return null;
                    }
                    $user = $model->byRunetId($data['RunetId'])->find();
                    return $user;
               },
               'valueAttributeName' => function (User $user) {
                    return \CHtml::link($user->getFullName(), $user->getUrl(), ['target' => '_blank']) . ' ('.$user->RunetId.')';
               }
            ],
            'Label'
        ];
    }
}
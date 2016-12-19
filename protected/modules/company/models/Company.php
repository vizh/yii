<?php
namespace company\models;

use application\components\Image;
use application\models\ProfessionalInterest;
use application\models\translation\ActiveRecord;
use application\widgets\IAutocompleteItem;
use commission\models\Commission;
use contact\models\Email;
use contact\models\Site;
use raec\models\CompanyUser;
use search\components\interfaces\ISearch;

/**
 * @property int $Id
 * @property string $Name
 * @property string $FullName
 * @property string $Info
 * @property string $FullInfo
 * @property string $CreationTime
 * @property string $UpdateTime
 * @property string $Code
 * @property string $Cluster
 *
 *
 * @property \company\models\LinkEmail $LinkEmail
 * @property \company\models\LinkEmail[] $LinkEmails
 * @property \company\models\LinkAddress $LinkAddress
 * @property \company\models\LinkPhone[] $LinkPhones
 * @property \company\models\LinkSite $LinkSite
 * @property \company\models\LinkModerator[] $LinkModerators
 * @property LinkCommission[] $LinkRaecClusters
 * @property CompanyUser[] $ActiveRaecUsers
 * @property CompanyUser[] $RaecUsers
 * @property Commission[] $RaecClusters
 * @property LinkProfessionalInterest[] $LinkProfessionalInterests
 * @property ProfessionalInterest[] $ProfessionalInterests
 * @property ProfessionalInterest $PrimaryProfessionalInterest
 *
 * @property \user\models\Employment[] $Employments
 * @property \user\models\Employment[] $EmploymentsAll
 * @property \user\models\Employment[] $EmploymentsAllWithInvisible
 *
 * Описание вспомогательных методов
 * @method Company   with($condition = '')
 * @method Company   find($condition = '', $params = [])
 * @method Company   findByPk($pk, $condition = '', $params = [])
 * @method Company   findByAttributes($attributes, $condition = '', $params = [])
 * @method Company[] findAll($condition = '', $params = [])
 * @method Company[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Company byId(int $id, bool $useAnd = true)
 * @method Company byCode(string $code, bool $useAnd = true)
 * @method Company byName(string $name, bool $useAnd = true)
 * @method Company byFullName(string $name, bool $useAnd = true)
 * @method Company byCluster(string $name, bool $useAnd = true)
 */
class Company extends ActiveRecord implements ISearch, IAutocompleteItem
{
    const CLUSTER_RAEC = 'РАЭК';

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Company';
    }

    public function relations()
    {
        return [
            'LinkEmail' => [self::HAS_ONE, '\company\models\LinkEmail', 'CompanyId'],
            'LinkEmails' => [self::HAS_MANY, '\company\models\LinkEmail', 'CompanyId'],
            'LinkAddress' => [self::HAS_ONE, '\company\models\LinkAddress', 'CompanyId'],
            'LinkSite' => [self::HAS_ONE, '\company\models\LinkSite', 'CompanyId'],
            'LinkPhones' => [self::HAS_MANY, '\company\models\LinkPhone', 'CompanyId'],
            'LinkModerators' => [self::HAS_MANY, '\company\models\LinkModerator', 'CompanyId'],
            'LinkRaecClusters' => [self::HAS_MANY, '\company\models\LinkCommission', 'CompanyId'],
            'LinkProfessionalInterests' => [self::HAS_MANY, '\company\models\LinkProfessionalInterest', 'CompanyId'],

            //Сотрудники
            'Employments' => [self::HAS_MANY, '\user\models\Employment', 'CompanyId', 'condition' => '"Employments"."EndYear" IS NULL AND "User"."Visible"', 'with' => ['User']],
            'EmploymentsAll' => [self::HAS_MANY, '\user\models\Employment', 'CompanyId', 'with' => ['User'], 'condition' => '"User"."Visible"'],
            'EmploymentsAllWithInvisible' => [self::HAS_MANY, '\user\models\Employment', 'CompanyId'],

            'ActiveRaecUsers' => [self::HAS_MANY, '\raec\models\CompanyUser', 'CompanyId', 'on' => '"ActiveRaecUsers"."ExitTime" IS NULL', 'with' => ['User']],
            'RaecUsers' => [self::HAS_MANY, '\raec\models\CompanyUser', 'CompanyId'],
            'RaecClusters' => [self::HAS_MANY, '\commission\models\Commission', ['CommissionId' => 'Id'], 'through' => 'LinkRaecClusters'],
            'ProfessionalInterests' => [self::HAS_MANY, '\application\models\ProfessionalInterest', ['ProfessionalInterestId' => 'Id'], 'through' => 'LinkProfessionalInterests', 'condition' => 'NOT "LinkProfessionalInterests"."Primary"'],
            'PrimaryProfessionalInterest' => [self::HAS_ONE, '\application\models\ProfessionalInterest', ['ProfessionalInterestId' => 'Id'], 'through' => 'LinkProfessionalInterests', 'condition' => '"LinkProfessionalInterests"."Primary"']
        ];
    }

    public function bySearch($term, $locale = null, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" ilike :Term';
        $criteria->params['Term'] = '%'.$term.'%';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * Отбирает компании, имеющих членство в РАЭК
     *
     * @param bool|true $raec
     * @param bool|true $useAnd
     */
    public function byRaec($raec = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $command = \Yii::app()->getDb()->createCommand();
        $command->select('CompanyId')->from('RaecCompanyUser')->where('"ExitTime" IS NULL');

        $criteria->addCondition('"t"."Id" '.(!$raec ? 'NOT' : '').' IN ('.$command->getText().')');
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    }

    /**
     * @return Image
     */
    public function getLogo()
    {
        return new Image($this, 'upload/images/company/logo/none.png', 'logo');
    }

    /**
     * @param string $fullName
     * @return string
     */
    public function parseFullName($fullName)
    {
        preg_match("/^([\'\"]*(ООО|ОАО|АО|ЗАО|ФГУП|ПКЦ|НОУ|НПФ|РОО|КБ|ИКЦ)?\s*,?\s+)?([\'\"]*)?([А-яЁёA-z0-9 \.\,\&\-\+\%\$\#\№\!\@\~\(\)]+)\3?([\'\"]*)?$/iu", $fullName, $matches);

        return (isset($matches[4])) ? $matches[4] : '';
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Name'];
    }

    /**
     *
     * @return \contact\models\Address
     */
    public function getContactAddress()
    {
        return !empty($this->LinkAddress) ? $this->LinkAddress->Address : null;
    }

    /**
     *
     * @param \contact\models\Address $address
     */
    public function setContactAddress($address)
    {
        $linkAddress = $this->LinkAddress;
        if ($linkAddress == null) {
            $linkAddress = new \company\models\LinkAddress();
            $linkAddress->CompanyId = $this->Id;
        }
        $linkAddress->AddressId = $address->Id;
        $linkAddress->save();
    }

    /**
     *
     * @param \contact\models\Phone $phone
     */
    public function setContactPhone($phone)
    {
        foreach ($this->LinkPhones as $link) {
            if ($link->PhoneId == $phone->Id) {
                return;
            }
        }

        $link = new LinkPhone();
        $link->CompanyId = $this->Id;
        $link->PhoneId = $phone->Id;
        $link->save();
    }

    /**
     * Добавляет адресс сайта
     *
     * @param string $url
     * @param bool $secure
     * @return \contact\models\Site
     */
    public function setContactSite($url)
    {
        $site = $this->getContactSite();
        if ($site === null) {
            $site = new Site();
        }

        $site->Url = parse_url($url, PHP_URL_HOST) ?: $url;
        $site->Secure = parse_url($url, PHP_URL_SCHEME) === 'https';
        $site->save();

        $link = $this->LinkSite;
        if (empty($link)) {
            $link = new LinkSite();
            $link->CompanyId = $this->Id;
        }

        $link->SiteId = $site->Id;
        $link->save();

        return $site;
    }

    /**
     * Сохраняет контактный адрес электронной почты
     *
     * @param string $email
     * @return Email
     */
    public function setContactEmail($email)
    {
        $model = $this->getContactEmail();
        if ($model === null) {
            $model = new Email();
        }

        $model->Email = $email;
        $model->save();

        $link = $this->LinkEmail;
        if (empty($link)) {
            $link = new LinkEmail();
            $link->CompanyId = $this->Id;
        }

        $link->EmailId = $model->Id;
        $link->save();

        return $model;
    }

    /**
     * @return Email|null
     */
    public function getContactEmail()
    {
        return !empty($this->LinkEmail) ? $this->LinkEmail->Email : null;
    }

    /**
     * @return \contact\models\Site|null
     */
    public function getContactSite()
    {
        return !empty($this->LinkSite) ? $this->LinkSite->Site : null;
    }

    public function getUrl()
    {
        return \Yii::app()->getController()->createAbsoluteUrl('/company/view/index', ['companyId' => $this->Id]);
    }

    /**
     * @param mixed $value
     *
     * @return \CActiveRecord
     */
    public function byAutocompleteValue($value)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Id" = :Id';
        $criteria->params = ['Id' => $value];
        $this->getDbCriteria()->mergeWith($criteria);

        return $this;
    }

    /**
     * @return string
     */
    public function getAutocompleteData()
    {
        return !empty($this->FullName) ? $this->FullName : $this->Name;
    }

    /**
     * @param string $name
     * @return Company
     * @throws \application\components\Exception
     */
    public static function create($name)
    {
        if (mb_strlen($name) === 0) {
            throw new \application\components\Exception(\Yii::t('app', 'Название компании не может быть пустым'));
        }
        $company = self::model()->byFullName($name)->byName($name, false)->find();
        if ($company == null) {
            $company = new Company();
            $company->setLocale(\Yii::app()->language);
            $company->Name = $name;
            $company->FullName = $name;
            $company->save();
        }

        return $company;
    }
}
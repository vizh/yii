<?php
namespace company\models;


/**
 * @throws \Exception
 *
 * @property int $Id
 * @property string $Name
 * @property string $FullName
 * @property string $Info
 * @property string $FullInfo
 * @property string $CreationTime
 * @property string $UpdateTime
 *
 *
 * @property \company\models\LinkEmail[] $LinkEmails
 * @property \company\models\LinkAddress $LinkAddress
 * @property \company\models\LinkPhone[] $LinkPhones
 * @property \company\models\LinkSite $LinkSite
 * @property \company\models\LinkModerator[] $LinkModerators
 *
 * @property \user\models\Employment[] $Employments
 * @property \user\models\Employment[] $EmploymentsAll
 *
 *
 * @method \company\models\Company find()
 * @method \company\models\Company findByPk()
 * @method \company\models\Company[] findAll()
 */
class Company extends \application\models\translation\ActiveRecord implements \search\components\interfaces\ISearch, \application\widgets\IAutocompleteItem
{
    /**
     * @param string $className
     * @return Company
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Company';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'LinkEmails' => array(self::HAS_MANY, '\company\models\LinkEmail', 'CompanyId'),
            'LinkAddress' => array(self::HAS_ONE, '\company\models\LinkAddress', 'CompanyId'),
            'LinkSite' => array(self::HAS_ONE, '\company\models\LinkSite', 'CompanyId'),
            'LinkPhones' => array(self::HAS_MANY, '\company\models\LinkPhone', 'CompanyId'),
            'LinkModerators' => array(self::HAS_MANY, '\company\models\LinkModerator', 'CompanyId'),

            //Сотрудники
            'Employments' => array(self::HAS_MANY, '\user\models\Employment', 'CompanyId', 'order' => '"User"."LastName" DESC', 'condition' => '"Employments"."EndYear" IS NULL AND "User"."Visible"', 'with' => array('User')),
            'EmploymentsAll' => array(self::HAS_MANY, '\user\models\Employment', 'CompanyId', 'with' => array('User')),
        );
    }

    public function byName($name, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Name" = :Name';
        $criteria->params['Name'] = $name;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byFullName($name, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."FullName" = :FullName';
        $criteria->params['FullName'] = $name;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function bySearch($term, $locale = null, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = 'to_tsvector("t"."Name") @@ plainto_tsquery(:Term)';
        $criteria->params['Term'] = $term;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }


    /** @var Logo */
    private $logo = null;

    /**
     * @return Logo
     */
    public function getLogo()
    {
        if ($this->logo === null)
        {
            $this->logo = new Logo($this);
        }
        return $this->logo;
    }

    /**
     * @param string $fullName
     * @return string
     */
    public function parseFullName($fullName)
    {
        preg_match("/^([\'\"]*(ООО|ОАО|АО|ЗАО|ФГУП|ПКЦ|НОУ|НПФ|РОО|КБ|ИКЦ)?\s*,?\s+)?([\'\"]*)?([А-яЁёA-z0-9 \.\,\&\-\+\%\$\#\№\!\@\~\(\)]+)\3?([\'\"]*)?$/iu", $fullName, $matches);

        $name = (isset($matches[4])) ? $matches[4] : '';
        return $name;
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return array('Name');
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
        if ($linkAddress == null)
        {
            $linkAddress = new \company\models\LinkAddress();
            $linkAddress->CompanyId = $this->Id;
        }
        $linkAddress->AddressId = $address->Id;
        $linkAddress->save();
    }

    /**
     * Добавляет адресс сайта
     * @param string $url
     * @param bool $secure
     * @return \contact\models\Site
     */
    public function setContactSite($url, $secure = false)
    {
        $contactSite = $this->getContactSite();
        if (empty($contactSite))
        {
            $contactSite = new \contact\models\Site();
            $contactSite->Url = $url;
            $contactSite->Secure = $secure;
            $contactSite->save();

            $linkSite = new LinkSite();
            $linkSite->CompanyId = $this->Id;
            $linkSite->SiteId = $contactSite->Id;
            $linkSite->save();
        }
        elseif ($contactSite->Url != $url || $contactSite->Secure != $secure)
        {
            $contactSite->Url = $url;
            $contactSite->Secure = $secure;
            $contactSite->save();
        }
        return $contactSite;
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
        return \Yii::app()->getController()->createAbsoluteUrl('/company/view/index', array('companyId' => $this->Id));
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
        if (mb_strlen($name) === 0)
        {
            throw new \application\components\Exception(\Yii::t('app', 'Название компании не может быть пустым'));
        }
        $company = self::model()->byFullName($name)->byName($name, false)->find();
        if ($company == null) {
            $company = new Company();
            $company->Name = $company->FullName = $name;
            $company->save();
        }
        return $company;
    }
}
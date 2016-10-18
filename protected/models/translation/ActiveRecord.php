<?php
namespace application\models\translation;

use ext\translator\Translite;

/**
 * Class ActiveRecord Base functionality for translations
 */
abstract class ActiveRecord extends \application\components\ActiveRecord
{
    private $_translations;

    private $_locale;

    /**
     * @var Translation[]
     */
    private $_changedTranslations = [];

    /**
     * Если перевода не существует или записано пустое значение,
     * то будет возвращаться транслитерированое значение
     * @var bool
     */
    private $returnTransliteIfEmpty = true;

    /**
     * @return string[]
     */
    public abstract function getTranslationFields();

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->tableName();
    }

    /**
     * Returns the name of the resource key. Method returns null when the table has composite key
     * @return string
     */
    public function getResourceKey()
    {
        $table = $this->getMetaData()->tableSchema;
        if (is_string($table->primaryKey)) {
            return $table->primaryKey;
        }

        return null;
    }

    /**
     * Returns the value for the resource key. It will be a unique identifier for the model
     * @return int|string
     */
    public function getResourceId()
    {
        $key = $this->getResourceKey();
        if (is_null($key)) {
            return null;
        }

        return $this->{$this->getResourceKey()};
    }

    /**
     * Sets locale
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->_locale = $locale;
    }

    /**
     * Returns locale
     * @return string|null
     */
    public function getLocale()
    {
        return $this->_locale;
    }

    /**
     * Resets locale
     */
    public function resetLocale()
    {
        $this->_locale = null;
    }

    /**
     * Adds search condition by using translation fields
     * @param string $locale
     * @param array $fields Параметры поиска, вида [$fieldName => $fieldValue, ...]
     * @param string $valueSuffix
     * @param bool $useAnd
     * @throws \Exception
     * @return ActiveRecord
     */
    public function byTranslationFields($locale, $fields, $valueSuffix = '%', $useAnd = true)
    {
        if (sizeof($fields) == 0) {
            throw new \Exception('Поиск по пустому списку параметров.');
        }

        $sql = 'AND (0=1';
        $i = 0;
        foreach ($fields as $key => $value) {
            if (!in_array($key, $this->getTranslationFields())) {
                throw new \Exception('Попытка поиска по полю, не включенному в список переводимых.');
            }

            $sql .= " OR tr.Field = :mkey{$i} AND tr.Value LIKE :mvalue{$i}";
            $params[':mkey' . $i] = $key;
            $params[':mvalue' . $i] = \Utils::PrepareStringForLike($value) . $valueSuffix;
            $i++;
        }
        $sql .= ')';

        $params[':ResourceName'] = $this->getResourceName();
        $params[':Locale'] = $locale;

        $command = \Yii::app()->getDb()->createCommand();
        $command->select('tr.ResourceId')->from('Translation tr');
        $command->where("tr.ResourceName = :ResourceName AND tr.Locale = :Locale {$sql}", $params);
        $command->group('tr.ResourceId');

        $command->having('count(tr.ResourceId) = :CountAttributes', array(':CountAttributes' => sizeof($fields)));

        $result = $command->queryAll();

        $userIdList = array();
        foreach ($result as $row) {
            $userIdList[] = $row['ResourceId'];
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t.' . $this->getResourceKey(), $userIdList);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param bool $return
     */
    public function setReturnTransliteIfEmpty($return)
    {
        $this->returnTransliteIfEmpty = $return;
    }

    /**
     * PHP getter magic method
     * This method is overridden so that AR attributes can be accessed like properties.
     * @param string $name property name
     * @return mixed property value
     * @see getAttribute
     */
    public function __get($name)
    {
        if (in_array($name, $this->getTranslationFields())) {
            return $this->getTranslationValue($name);
        } else {
            return parent::__get($name);
        }
    }

    /**
     * PHP setter magic method
     * This method is overridden so that AR attributes can be accessed like properties.
     * @param string $name property name
     * @param mixed $value property value
     * @return void
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->getTranslationFields())) {
            $this->setTranslationValue($name, $value);
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * PHP isset magic method
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        if (in_array($name, $this->getTranslationFields())) {
            return $this->hasTranslationValue($name);
        }
        return parent::__isset($name);
    }

    /**
     * @inheritdoc
     */
    protected function afterSave()
    {
        parent::afterSave();

        foreach ($this->_changedTranslations as $translation) {
            if ($translation->getIsNewRecord()) {
                $translation->ResourceId = $this->getResourceId();
            }
            $translation->save();
        }
    }

    /**
     * Initializes translation values
     */
    private function initTranslations()
    {
        if (is_null($this->_translations)) {
            $this->_translations = [];
            /** @var $translations Translation[] */
            $translations = Translation::model()
                ->byResourceName($this->getResourceName())
                ->byResourceId($this->getResourceId())
                ->findAll();

            foreach ($translations as $translation) {
                $this->_translations[$translation->Locale][$translation->Field] = $translation;
            }
        }
    }

    /**
     * Sets the translation value
     * @param string $field
     * @param string $value
     */
    private function setTranslationValue($field, $value)
    {
        $this->initTranslations();

        if ($this->_locale !== null && $this->_locale !== \Yii::app()->sourceLanguage) {
            if (!isset($this->_translations[$this->_locale][$field])) {
                $translation = new Translation();
                $translation->ResourceName = $this->getResourceName();
                $translation->Locale = $this->_locale;
                $translation->Field = $field;
                $this->_translations[$this->_locale][$field] = $translation;
            } else {
                $translation = $this->_translations[$this->_locale][$field];
            }
            $translation->Value = $value;
            $this->_changedTranslations[$this->_locale . $field] = $translation;

            //если локализованное значение пусто - заполнить его локализованным
            if (parent::__get($field) == null){
                parent::__set($field, $value);
            }
        } else {
            parent::__set($field, $value);
        }
    }

    /**
     * Returns true when the translation value exists
     * @param string $field
     * @return bool
     */
    private function hasTranslationValue($field)
    {
        if ($this->_locale !== null && $this->_locale !== \Yii::app()->sourceLanguage) {
            $this->initTranslations();
            return isset($this->_translations[$this->_locale][$field]);
        }

        return parent::__isset($field);
    }

    /**
     * Returns the translation value
     * @param string $field
     * @return string
     * @throws \Exception
     */
    private function getTranslationValue($field)
    {
        $locale = $this->_locale !== null ? $this->_locale : \Yii::app()->language;
        if ($locale != \Yii::app()->sourceLanguage) {
            $this->initTranslations();

            $value = '';
            if (isset($this->_translations[$locale][$field])) {
                $value = $this->_translations[$locale][$field]->Value;
            }

            if (empty($value) && $this->returnTransliteIfEmpty) {
                $value = parent::__get($field);
                if (!empty($value)) {
                    $translite = new Translite();
                    $value = $translite->translit($value, \Yii::app()->sourceLanguage, $locale);
                    $this->setTranslationValue($field, $value);
                }
            }
            return $value;
        }

        return parent::__get($field);
    }
}

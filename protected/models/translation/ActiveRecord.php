<?php
namespace application\models\translation;

abstract class ActiveRecord extends \application\components\ActiveRecord
{
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
* @return string
*/
  public function getResourceKey()
  {
    return $this->primaryKey();
  }

  /**
* @return mixed
*/
  public function getResourceId()
  {
    return $this->{$this->getResourceKey()};
  }



  /**
* PHP getter magic method.
* This method is overridden so that AR attributes can be accessed like properties.
* @param string $name property name
* @return mixed property value
* @see getAttribute
*/
  public function __get($name)
  {
    if (in_array($name, $this->getTranslationFields()))
    {
      return $this->getTranslationValue($name);
    }
    else
    {
      return parent::__get($name);
    }
  }

  /**
* PHP setter magic method.
* This method is overridden so that AR attributes can be accessed like properties.
* @param string $name property name
* @param mixed $value property value
* @return void
*/
  public function __set($name, $value)
  {
    if (in_array($name, $this->getTranslationFields()))
    {
      $this->setTranslationValue($name, $value);
    }
    else
    {
      parent::__set($name, $value);
    }
  }

  public function __isset($name)
  {
    if (in_array($name, $this->getTranslationFields()))
    {
      return $this->hasTranslationValue($name);
    }
    return parent::__isset($name);
  }


  private $_locale = null;
  public function setLocale($locale)
  {
    $this->_locale = $locale;
  }
  public function resetLocale()
  {
    $this->_locale = null;
  }

  private $_translations = null;

  private function initTranslations()
  {
    if ($this->_translations === null)
    {
      $this->_translations = array();
      /** @var $translations Translation[] */
      $translations = Translation::model()
        ->byResourceName($this->getResourceName())->byResourceId($this->getResourceId())
        ->findAll();
      foreach ($translations as $translation)
      {
        $this->_translations[$translation->Locale][$translation->Field] = $translation;
      }
    }
  }

  private function hasTranslationValue($field)
  {
    if ($this->_locale !== null && $this->_locale !== \Yii::app()->sourceLanguage)
    {
      $this->initTranslations();
      return isset($this->_translations[$this->_locale][$field]);
    }
    return parent::__isset($field);
  }


  private function getTranslationValue($field)
  {
    $locale = $this->_locale !== null ? $this->_locale : \Yii::app()->language;
    if ($locale != \Yii::app()->sourceLanguage)
    {
      $this->initTranslations();
      if (isset($this->_translations[$locale][$field]))
      {
        return $this->_translations[$locale][$field]->Value;
      }
      else
      {
        $value = parent::__get($field);
        if (!empty($value))
        {
          $translite = new \ext\translator\Translite();
          $value = $translite->translit($value, \Yii::app()->sourceLanguage, $locale);
          $this->setTranslationValue($field, $value);
          return $value;
        }
      }
    }

    return parent::__get($field);
  }

  /** @var Translation[] */
  private $_changedTranslations = array();

  private function setTranslationValue($field, $value)
  {
    if ($this->_locale !== null && $this->_locale !== \Yii::app()->sourceLanguage)
    {
      $this->initTranslations();
      if (!isset($this->_translations[$this->_locale][$field]))
      {
        $translation = new Translation();
        $translation->ResourceName = $this->getResourceName();
        $translation->Locale = $this->_locale;
        $translation->Field = $field;
        $this->_translations[$this->_locale][$field] = $translation;
      }
      else
      {
        $translation = $this->_translations[$this->_locale][$field];
      }
      $translation->Value = $value;
      $this->_changedTranslations[$this->_locale.$field] = $translation;
    }
    else
    {
      parent::__set($field, $value);
    }
  }

  protected function afterSave()
  {
    parent::afterSave();
    foreach ($this->_changedTranslations as $translation)
    {
      if ($translation->getIsNewRecord())
      {
        $translation->ResourceId = $this->getResourceId();
      }
      $translation->save();
    }
  }

  /**
*
* @param string $locale
* @param array $fields Параметры поиска, вида array($fieldName => $fieldValue, ...)
* @param string $valueSuffix
* @param bool $useAnd
* @throws \Exception
* @return ActiveRecord
*/
  public function byTranslationFields($locale, $fields, $valueSuffix = '%', $useAnd = true)
  {
    if (sizeof($fields) == 0)
    {
      throw new \Exception('Поиск по пустому списку параметров.');
    }

    $sql = 'AND (0=1';
    $i = 0;
    foreach ($fields as $key => $value)
    {
      if (!in_array($key, $this->getTranslationFields()))
      {
        throw new \Exception('Попытка поиска по полю, не включенному в список переводимых.');
      }

      $sql .= " OR tr.Field = :mkey{$i} AND tr.Value LIKE :mvalue{$i}";
      $params[':mkey'.$i] = $key;
      $params[':mvalue'.$i] = \Utils::PrepareStringForLike($value) . $valueSuffix;
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
    foreach ($result as $row)
    {
      $userIdList[] = $row['ResourceId'];
    }

    $criteria = new \CDbCriteria();
    $criteria->addInCondition('t.'.$this->getResourceKey(), $userIdList);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}

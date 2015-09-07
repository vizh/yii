<?php
namespace mail\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $TemplateId
 * @property string $CreationTIme
 * @property string $Error
 */
class TemplateLog extends \CActiveRecord implements \mail\components\ILog
{

    /**
     * @param string $className
     *
     * @return TemplateLog
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'MailTemplateLog';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @param int $templateId
     * @param bool $useAnd
     * @return $this
     */
    public function byTemplateId($templateId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."TemplateId" = :TemplateId';
        $criteria->params = array('TemplateId' => $templateId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param bool $hasError
     * @param bool $useAnd
     * @return $this
     */
    public function byHasError($hasError = false, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Error" IS ' . ($hasError ? 'NOT' : '') . ' NULL';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return $this
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = array('UserId' => $userId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function setError($error)
    {
        $this->Error = $error;
    }
}

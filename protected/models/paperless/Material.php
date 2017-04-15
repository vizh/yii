<?php

namespace application\models\paperless;

use application\components\ActiveRecord;
use application\components\CDbCriteria;
use event\models\Event;

/**
 * @property integer $Id
 * @property integer $EventId
 * @property string $Name
 * @property string $Comment
 * @property string $File
 * @property boolean $Active
 * @property boolean $Visible
 * @property string $PartnerName
 * @property string $PartnerSite
 * @property string $PartnerLogo
 *
 * @property Event $Event
 * @property MaterialLinkRole[] $RoleLinks
 *
 * Описание вспомогательных методов
 * @method Material   with($condition = '')
 * @method Material   find($condition = '', $params = [])
 * @method Material   findByPk($pk, $condition = '', $params = [])
 * @method Material   findByAttributes($attributes, $condition = '', $params = [])
 * @method Material[] findAll($condition = '', $params = [])
 * @method Material[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Material byId(int $id, bool $useAnd = true)
 * @method Material byEventId(int $id, bool $useAnd = true)
 * @method Material byName(string $name, bool $useAnd = true)
 * @method Material byComment(string $comment, bool $useAnd = true)
 * @method Material byFile(string $file, bool $useAnd = true)
 * @method Material byActive(bool $active = true, bool $useAnd = true)
 * @method Material byVisible(bool $visible = true, bool $useAnd = true)
 */
class Material extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessMaterial';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Name' => 'Название',
            'Comment' => 'Комментарий',
            'File' => 'Файл',
            'Active' => 'Активность',
            'Visible' => 'Отображать на сайте (если активен)',
            'activeLabel' => 'Материал активен',
            'Roles' => 'Статусы участия',
            'PartnerName' => 'Название партнера',
            'PartnerSite' => 'Сайт партнера',
            'PartnerLogo' => 'Логотип партнера',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Id', 'required', 'on' => 'update'],
            ['EventId,Name', 'required'],
            ['PartnerName,PartnerSite', 'length', 'max' => 255],
            ['Active,Visible', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, Event::className(), ['EventId']],
            'RoleLinks' => [self::HAS_MANY, MaterialLinkRole::className(), ['MaterialId']],
        ];
    }

    /**
     * Текстовое представление флага активности
     * @return string
     */
    public function getActiveLabel()
    {
        return $this->Active ? 'Активен' : 'Неактивен';
    }

    /**
     * Путь для сохранения файлов
     * @return string
     */
    public function getFilePath()
    {
        return \Yii::getPathOfAlias('webroot.files.paperless.material.file');
    }

    public function getFileUrl($absolute = false)
    {
        if (empty($this->File)) {
            return '';
        }

        $url = '/files/paperless/material/file/'.$this->File;

        return $absolute === true
            ? SCHEMA.'://'.RUNETID_HOST.$url
            : $url;
    }

    /**
     * Путь для сохранения логотипов партнеров
     * @return string
     */
    public function getPartnerLogoPath()
    {
        return \Yii::getPathOfAlias('webroot.files.paperless.material.partner-logo');
    }

    public function getPartnerLogoUrl($absolute = false)
    {
        if (empty($this->PartnerLogo)) {
            return '';
        }

        $url = '/files/paperless/material/partner-logo/'.$this->PartnerLogo;

        return $absolute === true
            ? SCHEMA.'://'.RUNETID_HOST.$url
            : $url;
    }

    /**
     * @param int|array $roleids
     * @param bool $useAnd
     */
    public function byRoleId($roleids, $useAnd = true)
    {
        if (false === is_array($roleids)) {
            $roleids = [$roleids];
        }

        $this->getDbCriteria()->mergeWith(
            CDbCriteria::create()
                ->setWith(['RoleLinks' => ['together' => true]])
                ->addInCondition('"RoleLinks"."RoleId"', $roleids, $useAnd ? 'AND' : 'OR')
        );
    }
}
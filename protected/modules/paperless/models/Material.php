<?php

namespace paperless\models;

use application\components\ActiveRecord;
use event\models\Event;
use Yii;

/**
 * @property integer $Id
 * @property integer $EventId
 * @property string $Name
 * @property string $Comment
 * @property string $File
 * @property boolean $Active
 * @property string $PartnerName
 * @property string $PartnerSite
 * @property string $PartnerFile
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
 * @method Material byActive(bool $active, bool $useAnd = true)
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
            'Active' => 'Материал активен',
            'activeLabel' => 'Материал активен',
            'Roles' => 'Статусы',
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
            ['EventId, Name, Active', 'required'],
            ['PartnerName, PartnerSite', 'length', 'max' => 255],
            ['Active', 'boolean'],
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
        return \Yii::getPathOfAlias('webroot.paperless.material.file');
    }

    public function getFileUrl($absolute = false)
    {
        if (!$this->File) {
            return '';
        }
        $url = '/paperless/material/file/'.$this->File;

        return rtrim($absolute ? Yii::app()->createAbsoluteUrl($url) : Yii::app()->createUrl($url), '/');
    }

    /**
     * Путь для сохранения логотипов партнеров
     * @return string
     */
    public function getPartnerLogoPath()
    {
        return \Yii::getPathOfAlias('webroot.paperless.material.partner-logo');
    }

    public function getPartnerLogoUrl($absolute = false)
    {
        if (!$this->File) {
            return '';
        }
        $url = '/paperless/material/partner-logo/'.$this->File;

        return rtrim($absolute ? Yii::app()->createAbsoluteUrl($url) : Yii::app()->createUrl($url), '/');
    }
}
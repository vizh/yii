<?php

namespace paperless\models;

use application\components\ActiveRecord;
use event\models\Role;

/**
 * @property integer $MaterialId
 * @property integer $RoleId
 *
 * @property Material $Material
 * @property Role $Role
 */
class MaterialLinkRole extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessMaterialLinkRole';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['MaterialId, RoleId', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Material' => [self::BELONGS_TO, Material::className(), ['MaterialId']],
            'Role' => [self::BELONGS_TO, Role::className(), ['RoleId']],
        ];
    }
}
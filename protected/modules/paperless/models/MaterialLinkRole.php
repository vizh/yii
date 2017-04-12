<?php

namespace paperless\models;

use application\components\ActiveRecord;
use event\models\Role;

/**
 * @property int $MaterialId
 * @property int $RoleId
 *
 * @property Material $Material
 * @property Role $Role
 *
 * Описание вспомогательных методов
 * @method MaterialLinkRole   with($condition = '')
 * @method MaterialLinkRole   find($condition = '', $params = [])
 * @method MaterialLinkRole   findByPk($pk, $condition = '', $params = [])
 * @method MaterialLinkRole   findByAttributes($attributes, $condition = '', $params = [])
 * @method MaterialLinkRole[] findAll($condition = '', $params = [])
 * @method MaterialLinkRole[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method MaterialLinkRole byMaterialId(int $id, bool $useAnd = true)
 * @method MaterialLinkRole byRoleId(int $id, bool $useAnd = true)
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
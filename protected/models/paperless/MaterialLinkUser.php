<?php

namespace application\models\paperless;

use application\components\ActiveRecord;
use event\models\Role;

/**
 * @property int $MaterialId
 * @property int $UserId
 *
 * @property Material $Material
 * @property Role $Role
 *
 * Описание вспомогательных методов
 * @method MaterialLinkUser   with($condition = '')
 * @method MaterialLinkUser   find($condition = '', $params = [])
 * @method MaterialLinkUser   findByPk($pk, $condition = '', $params = [])
 * @method MaterialLinkUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method MaterialLinkUser[] findAll($condition = '', $params = [])
 * @method MaterialLinkUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method MaterialLinkUser byMaterialId(int $id, bool $useAnd = true)
 * @method MaterialLinkUser byUserId(int $id, bool $useAnd = true)
 */
class MaterialLinkUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessMaterialLinkUser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['MaterialId, UserId', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Material' => [self::BELONGS_TO, Material::className(), ['MaterialId']],
            'Role' => [self::BELONGS_TO, Role::className(), ['UserId']],
        ];
    }
}
<?php
namespace event\components;

use application\components\attribute\JsonContainer;
use application\components\traits\ClassNameTrait;
use application\models\attribute\Definition;
use application\models\attribute\Group;
use event\models\UserData;

/**
 * Class UserDataManager
 *
 * @property UserData $model
 *
 * @method UserData model()
 */
class UserDataManager extends \CModel
{
    use JsonContainer;
    use ClassNameTrait;

    /**
     * @param UserData $userData
     * @throws \CException
     */
    public function __construct($userData)
    {
        $this->initJsonContainer($userData);
    }

    /**
     * Имя json-поля модели, для хранения данных
     *
     * @return string
     */
    protected function containerName()
    {
        return 'Attributes';
    }

    /**
     * Описание хранимых в контейнере аттрибутов.
     * Возможны 2 способа задания:
     * 1. ['Name1', 'Name2', ...] - список имен хранимых полей. В данном случае все поля
     * определяют объекты класса Definition
     * 2. [['Name', 'DefinitionClass', ...params],...] - каждое хранимое поле определяется тем классом,
     * который был указан после имени поля. Также возможно задать дополнительные параметры,
     * соответствующие DefinitionClass.
     *
     * @param bool $onlyPublic
     * @return string[]|array
     */
    protected function attributeDefinitions($onlyPublic = false)
    {
        $model = Definition::model()
            ->byModelName('EventUserData')
            ->byModelId($this->model()->EventId)
            ->ordered();

        if ($onlyPublic) {
            $model->byPublic(true);
        }

        $result = [];
        foreach ($model->findAll() as $definition) {
            $row = [
                0 => $definition->Name,
                1 => $definition->ClassName,
                2 => $definition->GroupId,
                'title' => $definition->Title,
                'required' => $definition->Required,
                'customTextField' => $definition->UseCustomTextField,
                'secure' => $definition->Secure,
                'public' => $definition->Public,
                'translatable' => $definition->Translatable
            ];

            $result[] = array_merge($row, $definition->getParams());
        }

        return $result;
    }

    public function attributeGroups()
    {
        $groups = Group::model()
            ->byModelName('EventUserData')
            ->byModelId($this->model()->EventId)
            ->findAll(['order' => '"t"."Order"']);

        $result = [];
        foreach ($groups as $group) {
            $result[] = [$group->Id, $group->Title, $group->Description];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return $this->definitionRules();
    }
}

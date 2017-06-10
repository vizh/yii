<?php
namespace ruvents\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;
use application\models\attribute\Definition;
use JsonSerializable;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Attributes
 *
 * @property string[] $EditableUserData
 * @property string[] $AvailableUserData
 *
 * Описание вспомогательных методов
 * @method Setting   with($condition = '')
 * @method Setting   find($condition = '', $params = [])
 * @method Setting   findByPk($pk, $condition = '', $params = [])
 * @method Setting   findByAttributes($attributes, $condition = '', $params = [])
 * @method Setting[] findAll($condition = '', $params = [])
 * @method Setting[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Setting byId(int $id, bool $useAnd = true)
 * @method Setting byEventId(int $id, bool $useAnd = true)
 */
class Setting extends ActiveRecord implements JsonSerializable
{
    private $settings;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsSetting';
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (\CException $e) {
            return property_exists($this->getSettings(), $name)
                ? $this->getSettings()->$name
                : null;
        }
    }

    /**
     * @inheritdoc
     */
    public function __isset($name)
    {
        if (property_exists($this->getSettings(), $name)) {
            return true;
        }

        return parent::__isset($name);
    }

    /**
     * @return \stdClass|null
     */
    public function getSettings()
    {
        if ($this->settings === null) {
            $this->settings = json_decode($this->Attributes);
        }

        return $this->settings;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $settings = $this->getSettings();

        if ($settings === null) {
            return null;
        }

        // Если определены редактируемые атрибуты, то получим их настройки. Данный код будет отрабатывать
        // в случае если для данного мероприятия будет проходить оффлайн регистрация. Задача кода - передать
        // Клиенту настройки редактирования полей пользовательских атрибутов
        if (isset($settings->EditableUserData) || isset($settings->AvailableUserData)) {
            $settingsEditableAttributes = array_merge(
                $settings->EditableUserData ?: [],
                $settings->AvailableUserData ?: []
            );

            if (!empty($settingsEditableAttributes)) {
                $definitions = Definition::model()
                    ->byModelId($this->EventId)
                    ->byModelName('EventUserData')
                    ->orderBy('"t"."Order"')
                    ->findAllByAttributes([
                        'Name' => array_merge(
                            $settings->EditableUserData ?: [],
                            $settings->AvailableUserData ?: []
                        )
                    ]);

                if (!empty($definitions)) {
                    $settings->PersonAttributes = [];
                    foreach ($definitions as $definition) {
                        $settings->PersonAttributes[$definition->Name] = array_filter(ArrayHelper::toArray($definition, [
                                'application\models\attribute\Definition' => [
                                    'Type' => 'ClassName',
                                    'Title',
                                    'Variants' => function (Definition $model) {
                                        $params = $model->getParams();

                                        return isset($params['data'])
                                            ? $params['data']
                                            : [];
                                    },
                                    'Editable' => function (Definition $model) use ($settings) {
                                        return isset($settings->EditableUserData) && in_array($model->Name, $settings->EditableUserData);
                                    }
                                ]
                            ]
                        ));
                    }
                }
            }

            unset($settings->EditableUserData, $settings->AvailableUserData);
        }

        return $settings;
    }
}
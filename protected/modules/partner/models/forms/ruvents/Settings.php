<?php
namespace partner\models\forms\ruvents;

use application\components\form\EventItemCreateUpdateForm;
use event\models\UserData;
use ruvents\models\Setting;

/**
 * @property Setting $model;
 */
class Settings extends EventItemCreateUpdateForm
{

    /** @var string[] Дополнительные атрибуты пользователя, доступные для редактирования из клиента */
    public $EditableUserData;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'EditableUserData' => \Yii::t('app', 'Дополнительные поля пользователя, доступные для редактирования'),
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['EditableUserData', '\application\components\validators\RangeValidator', 'range' => array_keys($this->getDefinitionData())]
        ];
    }


    /**
     * @return null|Setting
     */
    public function createActiveRecord()
    {
        $this->model = new Setting();
        $this->model->EventId = $this->event->Id;
        return $this->updateActiveRecord();
    }

    /**
     * @return Setting|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $attributes = $this->getAttributes($this->getSafeAttributeNames());
        foreach ($attributes as $name => $value) {
            if ($value != '0' && empty($value)) {
                unset($attributes[$name]);
            }
        }
        $this->model->Attributes = $this->getAttributesJson();
        $this->model->save();
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (!$this->isUpdateMode()) {
            return false;
        }
        $attributes = json_decode($this->model->Attributes);
        foreach ($attributes as $attr => $value) {
            if (property_exists($this, $attr)) {
                $this->$attr = $value;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    private function getAttributesJson()
    {
        $attributes = $this->getAttributes($this->getSafeAttributeNames());
        foreach ($attributes as $name => $value) {
            $isBoolean = false;

            $validators = $this->getValidators($name);
            foreach ($validators as $validator) {
                if ($validator instanceof \CBooleanValidator) {
                    $isBoolean = true;
                }
            }

            if ($isBoolean) {
                $attributes[$name] = (bool) $value;
            } elseif (empty($value)) {
                unset($attributes[$name]);
            }
        }
        return json_encode($attributes, JSON_UNESCAPED_UNICODE);
    }

    public function getDefinitionData()
    {
        $data = [];

        $userData = new UserData();
        $userData->EventId = $this->event->Id;
        foreach ($userData->getManager()->getDefinitions() as $definition) {
            $data[$definition->name] = $definition->title;
        }
        return $data;
    }
} 
<?php
namespace partner\models\forms\ruvents;

use application\components\form\EventItemCreateUpdateForm;
use ruvents\models\Setting;

/**
 * @property Setting $model;
 */
class Settings extends EventItemCreateUpdateForm
{

    public $TestAttribute1;
    public $TestAttribute2;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'TestAttribute1' => \Yii::t('app', 'Тестовый атрибут 1'),
            'TestAttribute2' => \Yii::t('app', 'Тестовый атрибут 2'),
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['TestAttribute1', 'required'],
            ['TestAttribute2', 'boolean']
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
} 
<?php
namespace application\components\form;

use application\components\helpers\ArrayHelper;
use application\helpers\Flash;
use CActiveRecord;
use user\models\User;

/**
 * Class CreateUpdateFormCombiner Combines few CreateUpdateForm object in this one
 */
abstract class CreateUpdateFormCombiner extends CreateUpdateForm
{
    /**
     * @var CreateUpdateForm[]
     */
    private $forms = [];

    /**
     * Внутри метода инициализуируется дочерние формы
     * @return mixed
     */
    abstract protected function initForms();

    /**
     * @inheritDoc
     */
    public function __construct(CActiveRecord $model = null)
    {
        $this->initForms();
        parent::__construct($model);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->forms as $form) {
            $rules = ArrayHelper::merge($rules, $form->rules());
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [];
        foreach ($this->forms as $form) {
            $labels = ArrayHelper::merge($labels, $form->attributeLabels());
        }

        return $labels;
    }

    /**
     * @inheritDoc
     */
    public function getAttributes($names = null)
    {
        $attributes = parent::getAttributes();
        foreach ($this->forms as $form) {
            $attributes = ArrayHelper::merge($attributes, $form->getAttributes());
        }

        return $attributes;
    }

    /**
     * @return null|User
     * @throws \CDbException
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->internalCreateActiveRecord();
            foreach ($this->forms as $form) {
                if ($form instanceof CreateUpdateForm) {
                    if (!$form->isUpdateMode()) {
                        $form->setActiveRecord($this->model);
                    }
                    $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
                }
            }

            $transaction->commit();

            return $this->model;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }

        return null;
    }

    /**
     * @return User|null
     * @throws \CDbException
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->internalUpdateActiveRecord();
            foreach ($this->forms as $form) {
                if ($form instanceof CreateUpdateForm) {
                    $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
                }
            }

            $transaction->commit();

            return $this->model;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function __get($name)
    {
        foreach ($this->forms as $form) {
            if (property_exists($form, $name)) {
                return $form->$name;
            }
        }

        return parent::__get($name);
    }

    /**
     * @inheritDoc
     */
    public function __set($name, $value)
    {
        foreach ($this->forms as $form) {
            if (property_exists($form, $name)) {
                return $form->$name = $value;
            }
        }

        return parent::__set($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function __isset($name)
    {
        if (array_key_exists($name, $this->getAttributes())) {
            return true;
        }
        return parent::__isset($name);
    }

    /**
     * @inheritDoc
     */
    protected function loadData()
    {
        if (!parent::loadData()) {
            return false;
        }

        foreach ($this->forms as $form) {
            if ($form instanceof CreateUpdateForm) {
                $form->setActiveRecord($this->model);
            }
        }

        return true;
    }

    /**
     * Регистрация формы
     * @param string $name
     * @param array $args
     * @throws \Exception
     */
    protected final function registerForm($name, $args = [])
    {
        $reflect = new \ReflectionClass($name);
        if ($reflect->getParentClass()->name === CreateUpdateForm::className()) {
            array_push($args, $this->model);
        }

        $form = $reflect->newInstanceArgs($args);
        if (!($form instanceof FormModel)) {
            throw new \Exception('Класс не является экземпляром классом \application\components\form\CreateUpdateForm');
        }

        $this->forms[$form->className()] = $form;
    }

    /**
     * @inheritDoc
     */
    protected function afterValidate()
    {
        parent::afterValidate();

        foreach ($this->forms as $form) {
            if ($form->hasErrors()) {
                $this->addErrors($form->getErrors());
            }
        }
    }

    /**
     * @return mixed
     */
    protected function internalUpdateActiveRecord()
    {
    }

    /**
     * @return mixed
     */
    protected function internalCreateActiveRecord()
    {
    }
}

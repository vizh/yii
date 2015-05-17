<?php

namespace application\components\form;

use application\components\Exception;

/**
 * Class CreateUpdateForm
 * @package partner\components\forms
 */
abstract class CreateUpdateForm extends FormModel
{
    /**
     * @var \CActiveRecord Редактируемая модель
     */
    protected $model;

    /**
     * @param \CActiveRecord $model
     */
    public function __construct(\CActiveRecord $model = null)
    {
        parent::__construct();
        $this->model = $model;
        $this->loadData();
    }

    /**
     * Создает запись в базе
     * @return \CActiveRecord|null
     * @throws Exception
     */
    public function createActiveRecord()
    {
        throw new Exception('Метод не реализован');
    }

    /**
     * Обновляет запись в базе
     * @return \CActiveRecord|null
     * @throws Exception
     */
    public function updateActiveRecord()
    {
        throw new Exception('Метод не реализован');
    }

    /**
     * @return \CActiveRecord|null
     */
    public function getActiveRecord()
    {
        return $this->model;
    }

    /**
     * Возвращает булево значение обозначающее, является ли текщий режим редактированием, либо созданием новой модели
     * @return bool
     */
    public function isUpdateMode()
    {
        if (empty($this->model) || $this->model->getIsNewRecord()) {
            return false;
        }
        return true;
    }

    /**
     * Загружает данные из модели в модель формы
     * @return bool Удалось ли загрузить данные
     */
    protected function loadData()
    {
        if (!$this->isUpdateMode()) {
            return false;
        }
        foreach ($this->getAttributes() as $attr => $value) {
            if ($this->model->hasAttribute($attr)) {
                $this->$attr = $this->model->$attr;
            }
        }
        return true;
    }

    /**
     * Заполняет модель данными из формы
     * @return bool
     */
    protected function fillActiveRecord()
    {
        if (!$this->isUpdateMode()) {
            return false;
        }

        foreach ($this->getAttributes() as $attr => $value) {
            if ($this->isAttributeSafe($attr) && $this->model->hasAttribute($attr)) {
                $this->model->$attr = $value;
            }
        }
        return true;
    }
}
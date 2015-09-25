<?php
namespace event\components\widget;

use application\components\form\CreateUpdateForm;
use event\components\Widget;
use event\models\Attribute;
use event\models\Event;

/**
 * Class WidgetAdminPanelForm
 * @package event\components\widget
 *
 * @property Event $model
 *
 * @method Event getActiveRecord()
 */
class WidgetAdminPanelForm extends CreateUpdateForm
{
    /** @var Widget */
    protected $widget;

    /**
     * @param Widget $widget
     */
    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
        parent::__construct($widget->getEvent());
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (!$this->isUpdateMode()) {
            return false;
        }

        foreach ($this->getAttributes() as $name => $value) {
            if (isset($this->widget->$name)) {
                $this->$name = $this->widget->$name;
            }
        }
        return true;
    }

    /**
     * Обновляет запись в базе
     * @return Event|null
     * @throws Exception
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        foreach ($this->getAttributes() as $name => $value) {
            if ($this->$name !== null && !($this->$name instanceof \CUploadedFile)) {
                $attribute = $this->getAttributeActiveRecord($name);
                $attribute->Value = $value;
                $attribute->save();
            }
        }
        return $this->model;
    }

    /**
     * @param string $name
     * @return Attribute
     */
    protected function getAttributeActiveRecord($name)
    {
        $attribute = Attribute::model()->byName($name)->byEventId($this->widget->getEvent()->Id)->find();
        if ($attribute == null) {
            $attribute = new Attribute();
            $attribute->EventId = $this->widget->getEvent()->Id;
            $attribute->Name = $name;
        }
        return $attribute;
    }
}
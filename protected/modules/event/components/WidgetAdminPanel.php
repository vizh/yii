<?php
namespace event\components;

use event\components\widget\WidgetAdminPanelForm;

abstract class WidgetAdminPanel implements IWidgetAdminPanel
{
    protected $widget;

    /** @var null|WidgetAdminPanelForm */
    protected $form;

    public function __construct($widget)
    {
        $this->widget = $widget;
        $this->form = $this->getForm();
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        if ($this->form === null) {
            throw new \CException('Метод не реализован');
        }
        return $this->renderView(['form' => $this->form]);
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        if ($this->form === null) {
            throw new \CException('Метод не реализован');
        }

        $this->form->fillFromPost();
        if ($this->form->updateActiveRecord()) {
            $this->setSuccess('Настройки виджета успешно сохранены');
            return true;
        }
        $this->addError($this->form->getErrors());
        return false;
    }

    /**
     *
     * @return \event\components\IWidget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    public function getEvent()
    {
        return $this->widget->getEvent();
    }

    private $errors = [];

    public function addError($message)
    {
        if (is_array($message)) {
            foreach ($message as $errors) {
                foreach ($errors as $message) {
                    $this->addError($message);
                }
            }
        } else {
            $this->errors[] = $message;
        }
    }

    protected function renderView($params = [])
    {
        $class = get_class($this);
        $class = substr($class, mb_strrpos($class, 'panels\\') + 7, mb_strlen($class));
        $class = str_replace('\\', '.', mb_strtolower($class));
        $view = 'event.widgets.panels.views.'.$class;
        $params = array_merge($params, ['widget' => $this->getWidget()]);
        return \Yii::app()->getController()->renderPartial($view, $params, true);
    }

    /**
     *
     * @param string $header
     * @param string $footer
     * @return string
     */
    public function errorSummary($header = '', $footer = '')
    {
        if (empty($this->errors)) {
            return '';
        }

        $result = $header.'<div class="errorSummary"><ul>';
        foreach ($this->errors as $error) {
            $result .= '<li>'.$error.'</li>';
        }

        $result .= '</ul></div>'.$footer;
        return $result;
    }

    const FLASH_SUCCESS_KEY = 'wap.success';

    public function setSuccess()
    {
        \Yii::app()->getUser()->setFlash(self::FLASH_SUCCESS_KEY, \Yii::t('app', 'Настройки виджета успешно сохранены'));
    }

    public function getSuccess()
    {
        return \Yii::app()->getUser()->getFlash(self::FLASH_SUCCESS_KEY);
    }

    public function hasSuccess()
    {
        return \Yii::app()->getUser()->hasFlash(self::FLASH_SUCCESS_KEY);
    }

    /**
     * @return null|WidgetAdminPanelForm
     */
    public function getForm()
    {
        return null;
    }
}

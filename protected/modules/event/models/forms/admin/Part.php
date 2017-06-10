<?php
namespace event\models\forms\admin;

class Part extends \CFormModel
{
    public $Part;

    public $Title;

    public $Order;

    public function __construct($partId = null, $eventId = null, $scenario = '')
    {
        if ($partId !== null) {
            $this->Part = \event\models\Part::model()->findByPk($partId);
            if ($this->Part->EventId != $eventId) {
                throw new \CHttpException(404);
            }

            $this->Title = $this->Part->Title;
            $this->Order = $this->Part->Order;
        } else {
            $this->Part = new \event\models\Part();
            $this->Part->EventId = $eventId;
        }
        return parent::__construct($scenario);
    }

    public function rules()
    {
        return [
            ['Title', 'required'],
            ['Order', 'filter', 'filter' => [$this, 'filterOrder']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название части'),
            'Order' => \Yii::t('app', 'Сортировка')
        ];
    }

    public function filterOrder($value)
    {
        $value = intval($value);
        if ($value == 0) {
            $value = \event\models\Part::model()->getMaxOrder($this->Part->EventId);
            $value++;
        }
        return $value;
    }

    public function save()
    {
        $this->Part->Title = $this->Title;
        $this->Part->Order = $this->Order;
        $this->Part->save();
    }
}
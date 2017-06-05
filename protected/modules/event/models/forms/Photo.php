<?php
namespace event\models\forms;

class Photo extends \CFormModel
{
    public $Image;

    public function rules()
    {
        return [
            ['Image', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Image' => \Yii::t('app', 'Фотография')
        ];
    }
}

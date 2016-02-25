<?php
namespace user\models\forms\edit;

/**
 * Class Photo Form model for the user photo
 */
class Photo extends \CFormModel
{
    /**
     * @var \CUploadedFile
     */
    public $Image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Image', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Image' => \Yii::t('app', 'Фотография профиля')
        ];
    }
}

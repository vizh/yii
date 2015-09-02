<?php
/**
 * Created by PhpStorm.
 * User: ������
 * Date: 04.08.2015
 * Time: 16:55
 */

namespace event\components\handlers\register;


use mail\models\Layout;
use partner\models\forms\program\Participant;
use event\models\Participant as ParticipantModel;


class Next2015 extends Base
{
    /**
     * @inheritdoc
     */
    public function getBody()
    {
        if ($this->requiredRegistrationConfirmation()) {
            return $this->renderBody('event.views.mail.register.next2015.confirm', []);
        }
        return parent::getBody();
    }

    /**
     * @inheritdoc
     */
    public function getLayoutName()
    {
        if ($this->requiredRegistrationConfirmation()) {
            return Layout::OneColumn;
        }
        return parent::getLayoutName();
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        if ($this->requiredRegistrationConfirmation()) {
            return 'Подтверждение регистрации школьников - ​Конференция Поколение NEXT "Школа Новых Технологий"';
        }
        return parent::getSubject();
    }


    /**
     * @inheritdoc
     */
    public function getAttachments()
    {
        if ($this->requiredRegistrationConfirmation()) {
            return [
                'Форма 1.xlsx' => \Yii::getPathOfAlias('webroot.docs.mail.next2015.forma1').'.xlsx'
            ];
        }
        return parent::getAttachments();
    }


    /**
     * @inheritdoc
     */
    protected function getRepeat()
    {
        if ($this->requiredRegistrationConfirmation()) {
            return true;
        }
        return false;
    }


    private function requiredRegistrationConfirmation()
    {
        return in_array($this->participant->PartId, [95,96,98,100]) && $this->participant->RoleId == 83;
    }
}
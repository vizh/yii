<?php
namespace event\components\handlers\register;

class Rif13 extends Base
{
    public function getFrom()
    {
        return 'users@rif.ru';
    }

    public function getSubject()
    {
        $subject = '';
        switch ($this->role->Id) {
            case 24:
                $subject = 'Регистрация на РИФ+КИБ 2013 в качестве "Виртуального участника"';
                break;

            case 1:
                $subject = 'Ваш статус на РИФ+КИБ 2013 изменен на "Участник" ';
                break;
        }
        return $subject;
    }

//  public function getAttachments()
//  {
//    $pkPassGen = new \application\components\utility\PKPassGenerator($this->event, $this->user, $this->role);
//    return array(
//      'ticket.pkpass' => $pkPassGen->runAndSave()
//    );
//  }

    public function getBody()
    {
        $view = null;
        switch ($this->role->Id) {
            case 24:
                $view = 'event.views.mail.register.rif13.role24';
                break;

            case 1:
                $view = 'event.views.mail.register.rif13.role1';
                break;
        }

        if ($view !== null) {
            return \Yii::app()->getController()->renderPartial($view, [
                'user' => $this->user,
                'role' => $this->role
            ], true);
        }
        return null;
    }
}

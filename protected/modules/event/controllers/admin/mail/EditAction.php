<?php
namespace event\controllers\admin\mail;

class EditAction extends \CAction
{
    private $event;

    public function run($eventId, $id = null)
    {
        $this->event = \event\models\Event::model()->findByPk($eventId);
        if ($this->event == null)
            throw new \CHttpException(404);

        $mail = $this->getMail($id);
        if ($mail == null)
            throw new \CHttpException(404);

        $form = new \event\models\forms\admin\mail\Register();
        $request = \Yii::app()->getRequest();

        $class = 'event.components.handlers.register.'.ucfirst($this->event->IdName);
        if (file_exists(\Yii::getPathOfAlias($class).'.php'))
        {
            $form->addError('Subject', \Yii::t('app', 'У мероприятия существует класс для отправки писем о регистрации. Пока сущеcтвует этот класс нельзя изменить насйтроки письма.'));
        }

        if ($request->getIsPostRequest())
        {
            $form->attributes = $request->getParam(get_class($form));
            if (!$form->hasErrors() && $form->validate())
            {
                if ($form->Delete == 1)
                {
                    $this->deleteMail($mail);
                    $this->getController()->redirect(
                        $this->getController()->createUrl('/event/admin/mail/index', ['eventId' => $this->event->Id])
                    );
                }

                $mail->Subject = $form->Subject;
                $mail->Body = $form->Body;
                $mail->Layout = $form->Layout;
                $mail->BodyRendered = str_replace(array_keys($this->fields()), $this->fields(), $form->Body);
                $mail->Roles = $form->Roles;
                $mail->RolesExcept = $form->RolesExcept;
                $mail->SendPassbook = $form->SendPassbook == 1 ? true : false;
                $this->saveMail($mail);
                \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Письмо успешно сохранено'));
                $this->getController()->redirect(
                    $this->getController()->createUrl('/event/admin/mail/edit', ['eventId' => $this->event->Id, 'id' => $mail->Id])
                );
            }
        }
        else
        {
            $form->Subject = $mail->Subject;
            $form->Body = $mail->Body;
            $form->Roles = $mail->Roles;
            $form->RolesExcept = $mail->RolesExcept;
            $form->Layout = $mail->Layout;
            if (isset($mail->SendPassbook))
            {
                $form->SendPassbook = $mail->SendPassbook;
            }
        }

        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование регистрационного письма'));
        \Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
        $this->getController()->render('edit', ['form' => $form, 'fields' => array_keys($this->fields()), 'event' => $this->event, 'mail' => $mail]);
    }

    /**
     * @param $id
     * @return \event\models\MailRegister
     */
    private function getMail($id)
    {
        if ($id !== null)
        {
            foreach ($this->getMails() as $mail)
            {
                if ($mail->Id == $id)
                    return $mail;
            }
            return null;
        }
        else
        {
            return new \event\models\MailRegister($this->event);
        }
    }

    /**
     * @return \event\models\MailRegister[]
     */
    private function getMails()
    {
        return isset($this->event->MailRegister) ? unserialize(base64_decode($this->event->MailRegister)) : [];
    }

    /**
     * @param \event\models\MailRegister $mail
     */
    private function deleteMail($mail)
    {
        $mails = $this->getMails();
        foreach ($mails as $key => $item)
        {
            if ($item->Id == $mail->Id)
            {
                unset($mails[$key]);
                break;
            }
        }
        $this->event->MailRegister = base64_encode(serialize($mails));
    }

    /**
     * @param \event\models\MailRegister $mail
     */
    private function saveMail($mail)
    {
        $mails = $this->getMails();
        $flag = false;
        foreach ($mails as $key => $item)
        {
            if ($item->Id == $mail->Id)
            {
                $mails[$key] = $mail;
                $flag = true;
                break;
            }
        }

        if (!$flag)
        {
            $mails[] = $mail;
        }
        file_put_contents($mail->getViewPath(), $mail->BodyRendered);
        $this->event->MailRegister = base64_encode(serialize($mails));
    }

    private function fields()
    {
        return [
            '{User.FullName}'  => '<?=$user->getFullName();?>',
            '{User.ShortName}' => '<?=$user->getShortName();?>',
            '{User.RunetId}'   => '<?=$user->RunetId;?>',
            '{Event.Title}'    => '<?=$event->Title;?>',
            '{TicketUrl}'      => '<?=$participant->getTicketUrl();?>',
            '{Role.Title}'     => '<?=$role->Title;?>',
            '{CalendarLinks}'  => '<?$this->renderPartial(\'event.views.mail.register.parts.calendar\', [\'event\' => $event]);?>'
        ];
    }

    public function getFieldLabel($field)
    {
        $labels = [
            '{User.FullName}'  => \Yii::t('app', 'Полное имя пользователя'),
            '{User.ShortName}' => \Yii::t('app', 'Краткое имя пользователя. Имя или имя + отчество'),
            '{User.RunetId}'   => \Yii::t('app', 'RUNET-ID пользователя'),
            '{Event.Title}'    => \Yii::t('app', 'Название меропрития'),
            '{TicketUrl}'      => \Yii::t('app', 'Ссылка на пригласительный'),
            '{Role.Title}'     => \Yii::t('app', 'Роль на меропритие'),
            '{CalendarLinks}'  => \Yii::t('app', 'Добавление в календарь')
        ];
        return $labels[$field];
    }
} 
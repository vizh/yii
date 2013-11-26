<?php
namespace event\controllers\admin\mail;

class RegisterAction extends \CAction
{
  private function fields()
  {
    return [
      '{User.FullName}'  => '<?=$user->getFullName();?>',
      '{User.ShortName}' => '<?=$user->getShortName();?>',
      '{User.RunetId}'   => '<?=$user->RunetId;?>',
      '{Event.Title}'    => '<?=$event->Title;?>',
      '{TicketUrl}'      => '<?=$participant->getTicketUrl();?>',
      '{Role.Title}'     => '<?=$role->Title;?>'
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
      '{Role.Title}'     => \Yii::t('app', 'Роль на меропритие')
    ];
    return $labels[$field];
  }

  public function run($eventId)
  {
    $event = \event\models\Event::model()->findByPk($eventId);
    if ($event == null)
      throw new \CHttpException(404);

    $form = new \event\models\forms\admin\mail\Register();
    $request = \Yii::app()->getRequest();

    $class = 'event.components.handlers.register.'.ucfirst($event->IdName);
    if (file_exists(\Yii::getPathOfAlias($class).'.php'))
    {
      $form->addError('Subject', \Yii::t('app', 'У мероприятия существует класс для отправки писем о регистрации. Пока сущеcтвует этот класс нельзя изменить насйтроки письма.'));
    }

    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      if (!$form->hasErrors() && $form->validate())
      {
        $event->MailRegisterSubject = $form->Subject;
        $event->MailRegisterBody = $form->Body;
        $event->MailRegisterBodyRendered = str_replace(array_keys($this->fields()), $this->fields(), $form->Body);
        $path = \Yii::getPathOfAlias('event.views.mail.register.'.strtolower($event->IdName)).'.php';
        file_put_contents($path, $event->MailRegisterBodyRendered);
        \Yii::app()->getUser()->setFlash('success', \Yii::t('app', 'Письмо успешно сохранено'));
        $this->getController()->refresh();
      }
    }
    else
    {
      $form->Subject = isset($event->MailRegisterSubject) ? $event->MailRegisterSubject : null;
      $form->Body = isset($event->MailRegisterBody) ? $event->MailRegisterBody : null;
    }

    \Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
    $this->getController()->render('register', ['form' => $form, 'fields' => array_keys($this->fields()), 'event' => $event]);
  }
} 
<?php
class CreateController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $request = \Yii::app()->getRequest();
    $form = new \event\models\forms\Create();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      $event = new \event\models\Event();
      $event->Title = $form->Title;
      $event->Info = $form->Info;
      if (!empty($form->FullInfo))
      {
        $event->FullInfo = $form->FullInfo;
      }
      $event->External = true;
      
      $translit = new \ext\translator\Translite();
      $event->IdName = $translit->translit($event->Title);
      
      $startDate = getdate($form->StartTimestamp);
      $event->StartYear = $startDate['year'];
      $event->StartMonth = $startDate['mon'];
      $event->StartDay = $startDate['mday'];
      
      $endDate = getdate($form->EndTimestamp);
      $event->EndYear = $endDate['year'];
      $event->EndMonth = $endDate['mon'];
      $event->EndDay = $endDate['mday'];
      
      $event->save();
      
      if (!empty($form->Url))
      {
        $event->setContactSite($form->Url);
      }
      
      $address = new \contact\models\Address();
      $address->Place = $form->Place;
      $address->save();
      $linkAddress = new \event\models\LinkAddress();
      $linkAddress->AddressId = $address->Id;
      $linkAddress->EventId = $event->Id;
      $linkAddress->save();
      
      $attribute = new \event\models\Attribute();
      $attribute->Name = 'ContactPerson';
      $attributeValue = array(
        'Name'  => $form->ContactName,
        'Email' => $form->ContactEmail,
        'Phone' => $form->ContactPhone,
      );
      $attribute->Value = serialize($attributeValue);
      $attribute->EventId = $event->Id;
      $attribute->save();
      
      $attribute = new \event\models\Attribute();
      $attribute->Name  = 'Options';
      $attributeValue = array();
      foreach($form->Options as $option)
      {
        $attributeValue[] = $form->getOptionValue($option);
      }
      $attribute->Value = serialize($attributeValue);
      $attribute->EventId = $event->Id;
      $attribute->save();
      
      $mail = new \ext\mailer\PHPMailer(false);
      $mail->AddAddress(\Yii::app()->params['EmailEventCalendar']);
      $mail->AddAddress('andrey.korotov@yandex.ru');
      $mail->AddAddress('nikitin@internetmediaholding.com');
      $mail->SetFrom('event@'.RUNETID_HOST, 'RUNET-ID', false);
      $mail->CharSet = 'utf-8';
      $mail->Subject = '=?UTF-8?B?'. base64_encode(\Yii::t('app', 'Получено новое мероприятие')) .'?=';
      $mail->IsHTML(false);
      $mail->MsgHTML(
        $this->renderPartial('email', array('form' => $form), true)
      );
      $mail->Send();
      
      \Yii::app()->user->setFlash('success', \Yii::t('app', '<h4 class="m-bottom_5">Поздравляем!</h4>Мероприятие отправлено. В ближайшее время c Вами свяжутся.'));
      $this->refresh();
    }
    
    $this->bodyId = 'event-create';
    $this->render('index', array('form' => $form));
  }
}

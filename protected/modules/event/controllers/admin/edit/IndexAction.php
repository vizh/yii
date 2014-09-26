<?php
namespace event\controllers\admin\edit;

class IndexAction extends \CAction
{
    public function run($eventId = null)
    {
        $form = new \event\models\forms\admin\Edit();
        if ($eventId !== null)
        {
            $event = \event\models\Event::model()->findByPk($eventId);
            if ($event == null)
            {
                throw new \CHttpException(404);
            }

            $attributes = $event->getAttributes();
            foreach ($event->getInternalAttributes() as $attribute)
            {
                $attributes[$attribute->Name] = $attribute->Value;
            }
            foreach ($attributes as $attribute => $value)
            {
                if (property_exists($form, $attribute))
                    $form->$attribute = $value;
            }
            $form->StartDate = $event->getFormattedStartDate(\event\models\forms\admin\Edit::DATE_FORMAT);
            $form->EndDate = $event->getFormattedEndDate(\event\models\forms\admin\Edit::DATE_FORMAT);
            $form->ProfInterest = \CHtml::listData($event->LinkProfessionalInterests, 'Id', 'ProfessionalInterestId');
            if ($event->LinkSite !== null)
            {
                $form->SiteUrl = (string) $event->LinkSite->Site;
            }

            if (!empty($event->LinkPhones))
            {
                $form->Phone->attributes = [
                    'Id' => $event->LinkPhones[0]->Phone->Id,
                    'OriginalPhone' => $event->LinkPhones[0]->Phone->getWithoutFormatting(),
                    'Type' => $event->LinkPhones[0]->Phone->Type
                ];
            }

            if (!empty($event->LinkEmails))
            {
                $form->Email = $event->LinkEmails[0]->Email->Email;
            }

            if ($event->getContactAddress() != null)
            {
                $form->Address->setAttributes(
                    $event->getContactAddress()->getAttributes($form->Address->getSafeAttributeNames())
                );
            }
        }
        else
        {
            $event = new \event\models\Event();
            $event->External = false;
        }


        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest())
        {
            $form->attributes = $request->getParam(get_class($form));
            $form->Logo = \CUploadedFile::getInstance($form, 'Logo');
            if ($form->validate())
            {
                // Сохранение мероприятия
                $event->IdName = $form->IdName;
                $event->Title = $form->Title;
                $event->Info = $form->Info;
                $event->FullInfo = $form->FullInfo;
                $event->Visible = $form->Visible;
                $event->TypeId = $form->TypeId;
                $event->ShowOnMain = $form->ShowOnMain;
                $event->Approved = $form->Approved;
                $event->StartDay = date('d', $form->StartDateTS);
                $event->StartMonth = date('m', $form->StartDateTS);;
                $event->StartYear = date('Y', $form->StartDateTS);;
                $event->EndDay = date('d', $form->EndDateTS);
                $event->EndMonth = date('m', $form->EndDateTS);;
                $event->EndYear = date('Y', $form->EndDateTS);;
                $event->save();

                $event->Top = $form->Top;
                $event->Free = $form->Free;
                $event->UnsubscribeNewUser = $form->UnsubscribeNewUser;


                // Сохранение адреса
                $address = $event->getContactAddress();
                if ($address == null)
                {
                    $address = new \contact\models\Address();
                }

                $address->setAttributes($form->Address->getAttributes(), false);
                $address->save();
                $event->setContactAddress($address);

                if (!$form->Phone->getIsEmpty())
                {
                    $this->savePhone($event, $form->Phone);
                }
                $this->saveEmail($event, $form->Email);

                // Сохранение сайта
                if (!empty($form->SiteUrl))
                {
                    $parseUrl = parse_url($form->SiteUrl);
                    $url = $parseUrl['host'].(!empty($parseUrl['path']) ? rtrim($parseUrl['path'], '/').'/' : '').(!empty($parseUrl['query']) ? '?'.$parseUrl['query'] : '');
                    $event->setContactSite($url, ($parseUrl['scheme'] == 'https' ? true : false));
                }

                // Сохранение логотипа
                if ($form->Logo !== null)
                {
                    $event->getLogo()->save($form->Logo->getTempName());
                }

                // Сохранение виджетов
                foreach ($form->Widgets as $class => $params)
                {
                    $widgetClass = \event\models\WidgetClass::model()->byClass($class)->find();
                    if ($widgetClass == null)
                        continue;

                    $linkWidget = \event\models\LinkWidget::model()->byEventId($event->Id)->byClassId($widgetClass->Id)->find();
                    if ($linkWidget == null && $params['Activated'] == 1)
                    {
                        $linkWidget = new \event\models\LinkWidget();
                        $linkWidget->EventId = $event->Id;
                        $linkWidget->ClassId = $widgetClass->Id;
                        $linkWidget->Order   = $params['Order'];
                        $linkWidget->save();
                    }
                    else if ($linkWidget !== null && $params['Activated'] == 0)
                    {
                        $linkWidget->delete();
                    }
                    else if ($linkWidget !== null && $params['Activated'] == 1)
                    {
                        $linkWidget->Order = $params['Order'];
                        $linkWidget->save();
                    }
                }

                // Сохранение проф. интересов
                foreach (\application\models\ProfessionalInterest::model()->findAll() as $profInterest)
                {
                    $linkProfInterest = \event\models\LinkProfessionalInterest::model()
                        ->byEventId($eventId)->byInteresId($profInterest->Id)->find();

                    if (in_array($profInterest->Id, $form->ProfInterest)
                        && $linkProfInterest == null)
                    {
                        $linkProfInterest = new \event\models\LinkProfessionalInterest();
                        $linkProfInterest->ProfessionalInterestId = $profInterest->Id;
                        $linkProfInterest->EventId = $event->Id;
                        $linkProfInterest->save();
                    }
                    else if (!in_array($profInterest->Id, $form->ProfInterest)
                        && $linkProfInterest !== null)
                    {
                        $linkProfInterest->delete();
                    }
                }

                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Мероприятие успешно сохранено'));
                $this->getController()->redirect(
                    $this->getController()->createUrl('/event/admin/edit/index', ['eventId' => $event->Id])
                );
            }
        }

        $widgetFactory = new \event\components\WidgetFactory();
        $widgets = new \stdClass();
        $widgets->All = $widgetFactory->getWidgets($event);
        foreach ($event->Widgets as $widget)
        {
            $widgets->Used[$widget->Name] = $widget;
        }
        \Yii::app()->clientScript->registerPackage('runetid.ckeditor');
        $this->getController()->render('index', array(
                'form'    => $form,
                'event'   => $event,
                'widgets' => $widgets)
        );
    }

    /**
     * @param \event\models\Event $event
     * @param \contact\models\Phone $form
     */
    private function savePhone($event, $form)
    {
        $hasLink = false;
        $phone = null;
        if (!empty($form->Id))
        {
            foreach ($event->LinkPhones as $link)
            {
                if ($link->PhoneId == $form->Id)
                {
                    $phone = $link->Phone;
                    $hasLink = true;
                    break;
                }
            }
        }
        if ($phone == null)
        {
            $phone = new \contact\models\Phone();
        }
        $phone->setAttributesFromForm($form);
        $phone->save();
        if (!$hasLink)
        {
            $link = new \event\models\LinkPhone();
            $link->EventId = $event->Id;
            $link->PhoneId = $phone->Id;
            $link->save();
        }
    }

    /**
     * @param \event\models\Event $event
     * @param string $email
     */
    private function saveEmail($event, $email)
    {
        $link = null;
        if (!empty($event->LinkEmails))
        {
            $link = $event->LinkEmails[0];
        }

        if (!empty($email))
        {
            $emailModel = $link !== null ? $link->Email : new \contact\models\Email();
            $emailModel->Email = $email;
            $emailModel->save();
            if ($link == null)
            {
                $link = new \event\models\LinkEmail();
                $link->EventId = $event->Id;
                $link->EmailId = $emailModel->Id;
                $link->save();
            }
        }
        elseif ($link !== null)
        {
            $link->Email->delete();
            $link->delete();
        }
    }
}

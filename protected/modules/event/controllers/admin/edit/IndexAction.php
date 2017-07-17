<?php
namespace event\controllers\admin\edit;

use application\models\ProfessionalInterest;
use contact\models\Address;
use contact\models\Email;
use contact\models\Phone;
use event\components\IWidget;
use event\models\Event;
use event\models\forms\admin\Edit;
use event\models\LinkEmail;
use event\models\LinkPhone;
use event\models\LinkProfessionalInterest;
use event\models\LinkWidget;
use event\models\WidgetClass;

class IndexAction extends \CAction
{
    public function run($eventId = null)
    {
        $form = new Edit();
        if ($eventId !== null) {
            $event = Event::model()->findByPk($eventId);
            if ($event == null) {
                throw new \CHttpException(404);
            }

            $attributes = $event->getAttributes();
            foreach ($event->getInternalAttributes() as $attribute) {
                $attributes[$attribute->Name] = $attribute->Value;
            }
            foreach ($attributes as $attribute => $value) {
                if (property_exists($form, $attribute)) {
                    $form->$attribute = $value;
                }
            }
            $form->StartDate = $event->getFormattedStartDate(Edit::DATE_FORMAT);
            $form->EndDate = $event->getFormattedEndDate(Edit::DATE_FORMAT);
            $form->ProfInterest = \CHtml::listData($event->LinkProfessionalInterests, 'Id', 'ProfessionalInterestId');
            if ($event->LinkSite !== null) {
                $form->SiteUrl = (string)$event->LinkSite->Site;
            }

            if (!empty($event->LinkPhones)) {
                $form->Phone->attributes = [
                    'Id' => $event->LinkPhones[0]->Phone->Id,
                    'OriginalPhone' => $event->LinkPhones[0]->Phone->getWithoutFormatting(),
                    'Type' => $event->LinkPhones[0]->Phone->Type
                ];
            }

            if (!empty($event->LinkEmails)) {
                $form->Email = $event->LinkEmails[0]->Email->Email;
            }

            if ($event->getContactAddress() != null) {
                $form->Address->setAttributes(
                    $event->getContactAddress()->getAttributes($form->Address->getSafeAttributeNames())
                );
            }

            $form->FullWidth = $event->FullWidth;
            $form->UserScope = $event->UserScope;
        } else {
            $event = new Event();
            $event->External = false;
        }

        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            $form->Logo = \CUploadedFile::getInstance($form, 'Logo');
            $form->TicketImage = \CUploadedFile::getInstance($form, 'TicketImage');
            if ($form->validate()) {
                // Сохранение мероприятия
                $event->IdName = $form->IdName;
                $event->Title = $form->Title;
                $event->Info = $form->Info;
                $event->FullInfo = $form->FullInfo;
                $event->Visible = $form->Visible;
                $event->TypeId = $form->TypeId;
                $event->VisibleOnMain = $form->VisibleOnMain;
                $event->Approved = $form->Approved;
                $event->StartDay = date('d', $form->StartDateTS);
                $event->StartMonth = date('m', $form->StartDateTS);
                $event->StartYear = date('Y', $form->StartDateTS);
                $event->EndDay = date('d', $form->EndDateTS);
                $event->EndMonth = date('m', $form->EndDateTS);
                $event->EndYear = date('Y', $form->EndDateTS);
                $event->FullWidth = $form->FullWidth;
                $event->UserScope = $form->UserScope;
                $event->save();

                $event->Top = $form->Top;
                $event->Free = $form->Free;
                $event->UnsubscribeNewUser = $form->UnsubscribeNewUser;
                $event->RegisterHideNotSelectedProduct = $form->RegisterHideNotSelectedProduct;
                $event->NotSendRegisterMail = $form->NotSendRegisterMail;
                $event->NotSendChangeRoleMail = $form->NotSendChangeRoleMail;
                $event->UseQuickRegistration = $form->UseQuickRegistration;
                $event->DocumentRequired = $form->DocumentRequired;

                // Сохранение адреса
                $address = $event->getContactAddress();
                if ($address == null) {
                    $address = new Address();
                }

                $address->setAttributes($form->Address->getAttributes(), false);
                $address->save();
                $event->setContactAddress($address);

                if (!$form->Phone->getIsEmpty()) {
                    $this->savePhone($event, $form->Phone);
                }
                $this->saveEmail($event, $form->Email);

                // Сохранение сайта
                if (!empty($form->SiteUrl)) {
                    $urlParts = parse_url($form->SiteUrl);

                    if (!isset($urlParts['path'])) {
                        $urlParts['path'] = '';
                    }
                    $url = $urlParts['host'].$urlParts['path'].(empty($urlParts['query']) ? '' : '?'.$urlParts['query']);

                    $event->setContactSite($url, $urlParts['scheme'] === 'https');
                }

                // Сохранение логотипа
                if ($form->Logo !== null) {
                    $event->getLogo()->save($form->Logo->getTempName());
                }

                if ($form->TicketImage !== null) {
                    $event->getTicketImage()->upload($form->TicketImage);
                }

                // Сохранение виджетов
                foreach ($form->Widgets as $class => $params) {
                    $widgetClass = WidgetClass::model()->byClass($class)->find();
                    if ($widgetClass == null) {
                        continue;
                    }

                    $linkWidget = LinkWidget::model()->byEventId($event->Id)->byClassId($widgetClass->Id)->find();
                    if ($linkWidget == null && $params['Activated'] == 1) {
                        $linkWidget = new LinkWidget();
                        $linkWidget->EventId = $event->Id;
                        $linkWidget->ClassId = $widgetClass->Id;
                        $linkWidget->Order = $params['Order'];
                        $linkWidget->save();
                    } else if ($linkWidget !== null && $params['Activated'] == 0) {
                        $linkWidget->delete();
                    } else if ($linkWidget !== null && $params['Activated'] == 1) {
                        $linkWidget->Order = $params['Order'];
                        $linkWidget->save();
                    }
                }

                // Сохранение проф. интересов
                foreach (ProfessionalInterest::model()->findAll() as $profInterest) {
                    $linkProfInterest = LinkProfessionalInterest::model()
                        ->byEventId($eventId)->byProfessionalInterestId($profInterest->Id)->find();

                    if (in_array($profInterest->Id, $form->ProfInterest) && $linkProfInterest == null) {
                        $linkProfInterest = new \event\models\LinkProfessionalInterest();
                        $linkProfInterest->ProfessionalInterestId = $profInterest->Id;
                        $linkProfInterest->EventId = $event->Id;
                        $linkProfInterest->save();
                    } else if (!in_array($profInterest->Id, $form->ProfInterest) && $linkProfInterest !== null) {
                        $linkProfInterest->delete();
                    }
                }

                $event->OrganizerInfo = $form->OrganizerInfo;
                $event->CloseRegistrationAfterEnd = $form->CloseRegistrationAfterEnd;

                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Мероприятие успешно сохранено'));
                $this->getController()->redirect(
                    $this->getController()->createUrl('/event/admin/edit/index', ['eventId' => $event->Id])
                );
            }
        }

        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование мероприятия'));
        \Yii::app()->clientScript->registerPackage('runetid.ckeditor');
        $this->getController()->render('index', [
            'form' => $form,
            'event' => $event,
            'widgets' => $this->getWidgets($event)
        ]);
    }

    /**
     * @param \event\models\Event $event
     * @param \contact\models\Phone $form
     */
    private function savePhone($event, $form)
    {
        $hasLink = false;
        $phone = null;
        if (!empty($form->Id)) {
            foreach ($event->LinkPhones as $link) {
                if ($link->PhoneId == $form->Id) {
                    $phone = $link->Phone;
                    $hasLink = true;
                    break;
                }
            }
        }
        if ($phone == null) {
            $phone = new Phone();
        }
        $phone->setAttributesFromForm($form);
        $phone->save();
        if (!$hasLink) {
            $link = new LinkPhone();
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
        if (!empty($event->LinkEmails)) {
            $link = $event->LinkEmails[0];
        }

        if (!empty($email)) {
            $emailModel = $link !== null ? $link->Email : new Email();
            $emailModel->Email = $email;
            $emailModel->save();
            if ($link == null) {
                $link = new LinkEmail();
                $link->EventId = $event->Id;
                $link->EmailId = $emailModel->Id;
                $link->save();
            }
        } elseif ($link !== null) {
            $link->Email->delete();
            $link->delete();
        }
    }

    /**
     * @param Event $event
     * @return \stdClass
     */
    private function getWidgets(Event $event)
    {
        $widgets = new \stdClass();
        $classes = WidgetClass::model()->byVisible(true)->findAll();
        /** @var WidgetClass $class */
        foreach ($classes as $class) {
            $widget = $class->createWidget($event, true);
            if ($widget instanceof IWidget) {
                $widgets->All[$widget->getName()] = $widget;
            }
        }

        foreach ($event->Widgets as $link) {
            $widget = $link->Class->createWidget($event, true);
            $widgets->Used[$widget->getName()] = $link;
        }

        return $widgets;
    }
}

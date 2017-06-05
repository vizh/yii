<?php
namespace event\models\forms;

use contact\models\Address;
use event\components\handlers\Create as HandlerCreate;
use event\components\handlers\Ruvents;
use event\models\Attribute;
use event\models\Event;
use event\models\LinkAddress;
use ext\translator\Translite;
use mail\components\mailers\PhpMailer;

class Create extends \CFormModel
{
    public $ContactName;
    public $ContactPhone;
    public $ContactEmail;
    public $Title;
    public $Place;
    public $City;
    public $LogoSource;
    public $StartDate;
    public $EndDate;
    public $OneDayDate;
    public $StartTimestamp;
    public $EndTimestamp;
    public $Url;
    public $Info;
    public $FullInfo;
    public $Options = [];
    public $PlannedParticipants;
    public $Company;

    public function rules()
    {
        return [
            ['ContactName, ContactPhone, ContactEmail, Title, City, Place, StartDate, EndDate, Info, FullInfo, Company', 'required'],
            ['ContactEmail', 'filter', 'filter' => 'trim'],
            ['FullInfo', 'filter', 'filter' => [$this, 'filterFullInfo']],
            ['Info, Options, OneDayDate, LogoSource', 'safe'],
            ['LogoSource', 'file', 'allowEmpty' => false],
            ['Url', 'url', 'allowEmpty' => false],
            ['ContactEmail', 'email'],
            ['StartDate', 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'StartTimestamp'],
            ['EndDate', 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'EndTimestamp'],
            ['PlannedParticipants', 'filter', 'filter' => [$this, 'filterPlannedParticipants']],
        ];
    }

    public function filterFullInfo($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements' => ['p', 'span', 'ol', 'li', 'strong', 'a', 'em', 's', 'ul', 'br', 'u', 'table', 'tbody', 'tr', 'td', 'thead', 'th', 'caption', 'h1', 'h2', 'h3', 'h4', 'h5', 'img', 'div'],
            'HTML.AllowedAttributes' => ['style', 'a.href', 'a.target', 'table.cellpadding', 'table.cellspacing', 'th.scope', 'table.border', 'img.alt', 'img.src', 'class'],
            'Attr.AllowedFrameTargets' => ['_blank', '_self']
        ];
        return $purifier->purify($value);
    }

    protected function beforeValidate()
    {
        $attributes = $this->attributes;
        if ($attributes['OneDayDate'] == 1) {
            $attributes['EndDate'] = $attributes['StartDate'];
        }
        $this->setAttributes($attributes);
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'ContactName' => \Yii::t('app', 'ФИО'),
            'ContactPhone' => \Yii::t('app', 'Контактный телефон'),
            'ContactEmail' => \Yii::t('app', 'Контактный email'),
            'Title' => \Yii::t('app', 'Название мероприятия'),
            'Place' => \Yii::t('app', 'Место проведения'),
            'Date' => \Yii::t('app', 'Дата проведения'),
            'Url' => \Yii::t('app', 'Сайт мероприятия'),
            'Info' => \Yii::t('app', 'Краткое описание'),
            'LogoSource' => \Yii::t('app', 'Логотип'),
            'FullInfo' => \Yii::t('app', 'Подробное описание'),
            'Options' => \Yii::t('app', 'Дополнительные опции'),
            'StartDate' => \Yii::t('app', 'Дата начала'),
            'EndDate' => \Yii::t('app', 'Дата окончания'),
            'OneDayDate' => \Yii::t('app', 'один день'),
            'PlannedParticipants' => \Yii::t('app', 'Планируемое кол-во участников'),
            'City' => \Yii::t('app', 'Город'),
            'Company' => \Yii::t('app', 'Компания организатор')
        ];
    }

    public function getOptionsData()
    {
        return [
            1 => \Yii::t('app', 'размещение информации в календаре'),
            2 => \Yii::t('app', 'регистрация участников'),
            3 => \Yii::t('app', 'прием оплаты'),
            5 => \Yii::t('app', 'реклама и маркетинг'),
            6 => \Yii::t('app', 'оффлайн регистрация')
        ];
    }

    public function getOptionValue($id)
    {
        $optionsData = $this->getOptionsData();
        return $optionsData[$id];
    }

    public function filterPlannedParticipants($value)
    {
        if (in_array(6, $this->Options) && empty($this->PlannedParticipants)) {
            $this->addError('PlannedParticipants', \Yii::t('app', 'Необходимо заполнить поле Планируемое кол-во участников'));
        }
        return $value;
    }

    public function save($form)
    {
        $event = new Event();
        $event->Title = $form->Title;
        $event->Info = $form->Info;
        if (!empty($form->FullInfo)) {
            $event->FullInfo = $form->FullInfo;
        }
        $event->External = true;

        $translit = new Translite();
        $event->IdName = preg_replace("|[^a-z]|i", "", $translit->translit($event->Title));
        $event->IdName = mb_substr($event->IdName, 0, 128);

        $startDate = getdate($form->StartTimestamp);
        $event->StartYear = $startDate['year'];
        $event->StartMonth = $startDate['mon'];
        $event->StartDay = $startDate['mday'];

        $endDate = getdate($form->EndTimestamp);
        $event->EndYear = $endDate['year'];
        $event->EndMonth = $endDate['mon'];
        $event->EndDay = $endDate['mday'];

        $event->LogoSource = \CUploadedFile::getInstance($form, 'LogoSource');

        if ($event->save()) {
            $LogoSource_path = $event->getPath($event->LogoSource, true);

            if (!file_exists(dirname($LogoSource_path))) {
                mkdir(dirname($LogoSource_path));
            }

            $event->LogoSource->saveAs($LogoSource_path);

            if (!empty($form->Url)) {
                $parseUrl = parse_url($form->Url);
                $url = $parseUrl['host'].(!empty($parseUrl['path']) ? rtrim($parseUrl['path'], '/').'/' : '').(!empty($parseUrl['query']) ? '?'.$parseUrl['query'] : '');
                $event->setContactSite($url, ($parseUrl['scheme'] == 'https' ? true : false));
            }

            $address = new Address();
            $address->Place = $form->City.', '.$form->Place;
            $address->save();
            $linkAddress = new LinkAddress();
            $linkAddress->AddressId = $address->Id;
            $linkAddress->EventId = $event->Id;
            $linkAddress->save();

            $attribute = new Attribute();
            $attribute->Name = 'OrganizerInfo';
            $attribute->Value = $form->Company;
            $attribute->EventId = $event->Id;
            $attribute->save();

            $attribute = new Attribute();
            $attribute->Name = 'ContactPerson';
            $attributeValue = [
                'Name' => $form->ContactName,
                'Email' => $form->ContactEmail,
                'Phone' => $form->ContactPhone,
                'RunetId' => \Yii::app()->getUser()->getCurrentUser()->RunetId,
            ];
            $attribute->Value = serialize($attributeValue);
            $attribute->EventId = $event->Id;
            $attribute->save();

            $attribute = new Attribute();
            $attribute->Name = 'Options';
            $attributeValue = [];
            foreach ($form->Options as $option) {
                $value = $form->getOptionValue($option);
                if ($option == 6 && !empty($form->PlannedParticipants)) {
                    $value .= ', '.$form->PlannedParticipants.' чел.';
                }
                $attributeValue[] = $value;
            }
            $attribute->Value = serialize($attributeValue);
            $attribute->EventId = $event->Id;
            $attribute->save();

            $mailer = new PhpMailer();
            $mail = new HandlerCreate($mailer, $form, $event);
            $mail->send();

            $mail2 = new HandlerCreate($mailer, $form, $event);
            $mail2->setTo('chertilov@internetmediaholding.com');
            $mail2->send();
            if (in_array(6, $form->Options)) {
                $mail = new Ruvents($mailer, $form);
                $mail->send();
            }
            \Yii::app()->user->setFlash('success', \Yii::t('app', '<h4 class="m-bottom_5">Поздравляем!</h4>Мероприятие отправлено. В ближайшее время c Вами свяжутся.'));
        }
    }
}

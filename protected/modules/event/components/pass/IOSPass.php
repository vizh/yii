<?php
namespace event\components\pass;

use event\models\Participant;
use Passbook\Pass\Barcode;
use Passbook\Pass\Field;
use Passbook\Pass\Image;
use Passbook\Pass\Structure;
use Passbook\PassFactory;
use Passbook\PassValidator;
use Passbook\Type\EventTicket;
use user\models\User;
use event\models\Event;
use event\models\Role;

class IOSPass
{
    const ORGANIZATION_NAME = 'RUNETID';
    const PASS_TYPE_IDENTIFIER = 'pass.runetid.event.ticket';
    const TEAM_IDENTIFIER = 'X9WVYYD744';

    /** @var User */
    private $user;

    /** @var Event */
    private $event;

    /** @var Role */
    private $role;

    /** @var EventTicket */
    private $pass;

    /**
     * @inheritDoc
     */
    public function __construct(Participant $participant)
    {
        $this->event = $participant->Event;
        $this->user  = $participant->User;
        $this->role  = $participant->Role;
        $this->init();
    }

    /**
     * Инициализация Passbook обькта
     */
    protected function init()
    {
        $pass = new EventTicket($this->getNumber(), $this->event->Title);
        $pass->setBackgroundColor('rgb(107,156,196)');

        $structure = new Structure();

        $field = new Field('date', $this->event->getFormattedStartDate('dd MMM'));
        $field->setLabel($this->event->getFormattedStartDate('yyyy'));
        $structure->addHeaderField($field);

        $field = new Field('event', $this->event->Title);
        $field->setLabel(\Yii::t('app', 'Мероприятие'));
        $structure->addPrimaryField($field);

        $field = new Field('name', $this->user->getFullName());
        $field->setLabel(\Yii::t('app', 'Имя'));
        $structure->addSecondaryField($field);

        $field = new Field('status', $this->role->Title);
        $field->setLabel(\Yii::t('app', 'Статус'));
        $structure->addAuxiliaryField($field);

        $field = new Field('runetid', $this->user->RunetId);
        $field->setLabel('RUNET—ID');
        $structure->addAuxiliaryField($field);

        $field = new Field('info', strip_tags($this->event->Info));
        $field->setLabel(\Yii::t('app', 'О мероприятии'));
        $structure->addBackField($field);

        $field = new Field('address', (string) $this->event->getContactAddress());
        $field->setLabel(\Yii::t('app', 'Адрес'));
        $structure->addBackField($field);

        $pass->setStructure($structure);

        $path = \Yii::getPathOfAlias('webroot.images.pkpass') . '/';
        $image = new Image($path . 'icon.png', 'icon');
        $pass->addImage($image);

        $image = new Image($path . 'background.png', 'background');
        $pass->addImage($image);

        $image = new Image($path . 'logo.png', 'logo');
        $pass->addImage($image);

        $barcode = new Barcode(Barcode::TYPE_QR, $this->user->getRuventsCode());
        $pass->setBarcode($barcode);

        $this->pass = $pass;
    }

    /**
     * @return string
     */
    private function getNumber()
    {
        return $this->event->Id . $this->user->RunetId;
    }

    /**
     * @return string
     */
    private function getOutputPath()
    {
        $path = \Yii::getPathOfAlias('application') . '/../data/pass/';
        $path.= substr($this->getNumber(), -4, 2);
        return $path;
    }

    /**
     * @return string
     */
    public function output()
    {
        $factory = new PassFactory(
            static::PASS_TYPE_IDENTIFIER,
            static::TEAM_IDENTIFIER,
            static::ORGANIZATION_NAME,
            __DIR__ . '/certificates/pass-certificate.p12',
            'nws3BB5XwAeFdEcnY3',
            __DIR__ . '/certificates/AppleWWDRCA.pem'
        );

        $factory->setOverwrite(true);
        $factory->setOutputPath($this->getOutputPath());

        return $factory
            ->package($this->pass)
            ->getPathname();
    }

    /**
     * @param Participant $participant
     * @return IOSPass
     */
    public static function create(Participant $participant)
    {
        return new static($participant);
    }
}
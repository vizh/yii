<?php
namespace application\components\utility;
class PKPassGenerator 
{
  private $standardKeys  = array(
    'description' => 'Электронный билет на посещение мероприятия',
    'formatVersion' => 1,
    'organizationName' => 'RUNET—ID',
    'passTypeIdentifier' => 'pass.runetid.event.ticket',
    'teamIdentifier' => 'X9WVYYD744'
  );
  private $associatedAppKeys = array();
  private $relevanceKeys = array();
  
  private $styleKeys = array();

  private $visualAppearanceKeys = array(
    'barcode' => array(
      'format' => 'PKBarcodeFormatQR',
      'message' => '',
      'messageEncoding' => 'iso-8859-1'
    ),
    'backgroundColor' => 'rgb(107,156,196)'
  );

  private $webServiceKeys = array();
  
  
  protected $event = null;
  protected $role  = null;
  protected $user  = null;
  
  
  /**
   * 
   * @param \event\models\Event $event
   * @param \user\models\User $user
   * @param \event\models\Role $role
   */
  public function __construct($event, $user, $role) 
  {
    $this->event = $event;
    $this->user  = $user;
    $this->role  = $role;
  }
  
  public function run($output = false)
  { 
    $this->standardKeys['serialNumber'] = $this->event->Id.$this->user->RunetId;
    $this->visualAppearanceKeys['barcode']['message'] = '~RUNETID#'.$this->user->RunetId.'$';
    $this->styleKeys = array(
      'eventTicket' => array(
        'headerFields' => array(
          array(
            'key'   => 'date',
            'label' => $this->event->getFormattedStartDate('yyyy'),
            'value' => $this->event->getFormattedStartDate('dd MMM'),
          )
        ),
        'primaryFields' => array(
          array(
            'key'   => 'event',
            'label' => \Yii::t('app', 'Мероприятие'),
            'value' => $this->event->Title
          )
        ),
        'secondaryFields' => array(
          array(
            'key'   => 'name',
            'label' => \Yii::t('app', 'Имя'),
            'value' => $this->user->getFullName()
          )
        ),
        'auxiliaryFields' => array(
          array(
            'key'   => 'status',
            'label' => \Yii::t('app', 'Статус'),
            'value' => $this->role->Title
          ),
          array(
            'key'   => 'runetid',
            'label' => 'RUNET—ID',
            'value' => $this->user->RunetId
          )
        ),
        'backFields' => array(
          array(
            'key'   => 'info',
            'label' => \Yii::t('app','О мероприятии'),
            'value' => strip_tags($this->event->Info)  
          ),
          array(
            'key'   => 'address',
            'label' => \Yii::t('app', 'Адрес'),
            'value' => (string) $this->event->getContactAddress()
          )
        ),
        'transitType' => 'PKTransitTypeAir'
      )
    );
    
    $data = array_merge(
      $this->standardKeys,
      $this->associatedAppKeys,
      $this->relevanceKeys,
      $this->styleKeys,
      $this->visualAppearanceKeys,
      $this->webServiceKeys
    );
    
    
    $pkPass = new \ext\pkpass\PKPass();
    $pkPass->setCertificate(
      \Yii::getPathOfAlias('ext.pkpass').'/certificates/pass-certificate.p12'
    );
    $pkPass->setCertificatePassword('QHqYBAi8on');
    $pkPass->setWWDRcertPath(
      \Yii::getPathOfAlias('ext.pkpass').'/certificates/AppleWWDRCA.pem'
    );

    $pkPass->addFile(\Yii::getPathOfAlias('webroot.images.pkpass').'/background.png');
    $pkPass->addFile(\Yii::getPathOfAlias('webroot.images.pkpass').'/background@2x.png');
    $pkPass->addFile(\Yii::getPathOfAlias('webroot.images.pkpass').'/logo.png');
    $pkPass->addFile(\Yii::getPathOfAlias('webroot.images.pkpass').'/icon.png');
    $pkPass->addFile(\Yii::getPathOfAlias('webroot.images.pkpass').'/icon@2x.png');
    $pkPass->setJSON(json_encode($data));
    return $pkPass->create($output);
  }
  
  /**
   * 
   * @return string 
   */
  public function runAndSave()
  {
    $path  = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    $path .= 'pkpass'.DIRECTORY_SEPARATOR.$this->user->RunetId.'_'.$this->event->IdName.'_'.$this->role->Id.'.pkpass';
    if (file_exists($path))
    {
      return $path;
    }
    else 
    {
      file_put_contents($path, $this->run(false));
      return $path;
    }
  }
}
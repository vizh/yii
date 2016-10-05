<?php
namespace user\models;

use application\components\ActiveRecord;
use application\components\Exception;
use Aws\Sns\SnsClient;
use Yii;

/**
 * @property int $Id
 * @property int $UserId
 * @property string $Type
 * @property string $Token
 *
 * @property User $User
 *
 * @method UserDevice byUserId(int $id)
 * @method UserDevice byToken(string $token)
 * @method UserDevice byType(string $type)
 *
 * Описание вспомогательных методов
 * @method UserDevice   with($condition = '')
 * @method UserDevice   find($condition = '', $params = [])
 * @method UserDevice   findByPk($pk, $condition = '', $params = [])
 * @method UserDevice   findByAttributes($attributes, $condition = '', $params = [])
 * @method UserDevice[] findAll($condition = '', $params = [])
 * @method UserDevice[] findAllByAttributes($attributes, $condition = '', $params = [])
 */
class UserDevice extends ActiveRecord
{
    public static $TYPE_IOS = 'iOS';
    public static $TYPE_ANDROID = 'Android';

    /**
     * @param string $className
     * @return UserDevice
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'UserDevice';
    }

    public function getPrimaryKey()
    {
        return 'Id';
    }

    public function behaviors()
    {
        return [
            ['class' => '\application\extensions\behaviors\TimestampableBehavior'],
            ['class' => '\application\extensions\behaviors\DeletableBehavior']
        ];
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }

    public function rules()
    {
        return [
            ['Type,Token', 'required'],
            ['Type', 'in', 'range' => [self::$TYPE_IOS, self::$TYPE_ANDROID], 'message' => 'Указан неверный тип устройства']
        ];
    }

    protected function beforeSave()
    {
        if (!$this->isNewRecord) {
            throw new Exception('Поддержка редактирования UserDevice не реализована');
        }

        $this->createDeviceEndpoint();
        $this->createDeviceSubscription();

        return parent::beforeSave();
    }

    protected function beforeDelete()
    {
        // toDo: Обдумать необходимость отписки и удаления Endpoint из SNS
        return parent::beforeDelete();
    }

    private static function getSnsClient()
    {
        static $client;

        if ($client === null) {
            $client = SnsClient::factory([
                'key' => Yii::app()->getParams()['AwsKey'],
                'secret' => Yii::app()->getParams()['AwsSecret'],
                'region' => Yii::app()->getParams()['AwsSnsRegion']
            ]);
        }

        return $client;
    }

    /**
     * Регистрирует устройство в службе отправки уведомлений
     *
     * @throws Exception
     */
    private function createDeviceEndpoint()
    {
        $result = self::getSnsClient()->createPlatformEndpoint([
            'CustomUserData' => "RunetId:{$this->User->RunetId}",
            'PlatformApplicationArn' => 'arn:aws:sns:eu-central-1:431010506613:app/APNS_SANDBOX/forinnovations.ios',
            'Token' => $this->Token
        ]);

        if ($result->hasKey('EndpointArn') === false) {
            throw new Exception("Ошибка регистрации устройства Token:{$this->Token} для посетителя {$this->User->RunetId}");
        }

        $this->setAttribute('SnsEndpointArn', $result->get('EndpointArn'));
    }

    /**
     * Подписывает устройство на канал уведомлений
     *
     * @throws Exception
     */
    private function createDeviceSubscription()
    {
        $result = self::getSnsClient()->subscribe([
            'Endpoint' => $this->getAttribute('SnsEndpointArn'),
            'Protocol' => 'application',
            'TopicArn' => 'arn:aws:sns:eu-central-1:431010506613:forinnovations'
        ]);

        if ($result->hasKey('SubscriptionArn') === false)
            throw new Exception("Ошибка оформления подписки устройства Token:{$this->Token} посетителя RunetId:{$this->User->RunetId} на канал уведомлений");

        $this->setAttribute('SnsSubscriptionArn', $result->get('SubscriptionArn'));
    }
}

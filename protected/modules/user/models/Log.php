<?php
namespace user\models;
use application\components\ActiveRecord;
use ext\ipgeobase\Geo;


/**
 * @property int $Id
 * @property int $UserId
 * @property string $IP
 * @property string $Country
 * @property string $City
 * @property string $UserAgent
 * @property string $Referal
 * @property string $CreationTime
 *
 * @method Log byUserId(int $userId)
 * @method Log[] findAll()
 *
 * @property User $User
 * @property \contact\models\Phone $Phone
 */
class Log extends ActiveRecord
{
    /**
     * @param string $className
     * @return Log
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'UserLog';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }

    static public function create($user)
    {
        $log = new Log();
        $log->UserId = $user->Id;
        $log->IP = $_SERVER['REMOTE_ADDR'];
        $log->UserAgent = $_SERVER['HTTP_USER_AGENT'];
        $log->Referal = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;

        $geoIpService = new Geo(['charset' => 'utf-8']);
        $geoIpData = $geoIpService->get_geobase_data();
        if (!empty($geoIpData)) {
            $log->Country = !empty($geoIpData['country']) ? $geoIpData['country'] : null;
            $log->City = !empty($geoIpData['city']) ? $geoIpData['city'] : null;
        }
        $log->save();
    }
}

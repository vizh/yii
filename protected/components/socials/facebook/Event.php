<?php
namespace application\components\socials\facebook;

/**
 * Class Event Инкапсулирует мероприятие Facebook на странице "RUNET-ID"
 * @package application\components\api\facebook
 */
final class Event extends FbProvider
{
    /**
     * @var string ID of the event in the Facebook
     */
    public $id;

    public $name;
    public $description;
    public $location;
    public $ticketUri;

    private $_startTime;
    private $_endTime;

    /**
     * Возвращает все мероприятия на странице RUNET-ID
     * @return mixed
     */
    public static function getAll()
    {
        return self::getFb()->api(self::PAGE_ID.'/events', 'GET');
    }

    /**
     * @param string $id ID of the event on Facebook
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Устанавливает дату/время начала мероприятия
     * @param string $date
     * @param string $time
     * @throws \CException
     */
    public function setStartTime($date, $time = null)
    {
        try {
            $datetime = new \DateTime($date.' '.$time);
        } catch (\Exception $e) {
            throw new \CException('Неверно задана дата или время!');
        }

        if ($time === null) {
            $this->_startTime = $datetime->format('Y-m-d');
        } else {
            $this->_startTime = $datetime->format(\DateTime::ISO8601);
        }
    }

    /**
     * Возвращает дату/время начала мероприятия
     * @return string
     */
    public function getStartTime()
    {
        return $this->_startTime;
    }

    /**
     * Устанавливает дату/время окончания мероприятия
     * @param string $date
     * @param string $time
     * @throws \CException
     */
    public function setEndTime($date, $time = null)
    {
        try {
            $datetime = new \DateTime($date.' '.$time);
        } catch (\Exception $e) {
            throw new \CException('Неверно задана дата или время!');
        }

        if ($time === null) {
            $this->_endTime = $datetime->format('Y-m-d');
        } else {
            $this->_endTime = $datetime->format(\DateTime::ISO8601);
        }
    }

    /**
     * Возвращает дату/время окончания мероприятия
     * @return string
     */
    public function getEndTime()
    {
        return $this->_endTime;
    }

    /**
     * Публикует мероприятие на странице RUNET-ID
     * Если указан id мероприятия, то просто обновляется информация
     * @return int Идентификатор мероприятия на Facebook
     */
    public function publish()
    {
        if (!empty($this->id)) {
            try {
                return $this->update();
            } catch (\FacebookApiException $e) {
                $this->id = null;
            }
        }

        $result = self::getFb()->api(self::PAGE_ID.'/events', 'POST', $this->getEventData());
        return $this->id = $result['id'];
    }

    /**
     * Обновляет информацию о мероприятии
     * @return bool
     * @throws \CException
     */
    public function update()
    {
        if (empty($this->id)) {
            throw new \CException('Идентификатор мероприятия не задан');
        }

        return self::getFb()->api('/'.$this->id, 'POST', $this->getEventData());
    }

    /**
     * Удаляет мероприятие
     * @return mixed
     * @throws \CException
     */
    public function delete()
    {
        if (empty($this->id)) {
            throw new \CException('Идентификатор мероприятия не задан');
        }

        return self::getFb()->api('/'.$this->id, 'DELETE');
    }

    /**
     * Устанавливает логотип для опубликованного мероприятия
     * @param $fileName Путь к логотипу
     * @return bool
     * @throws \CException
     */
    public function setPicture($fileName)
    {
        if (empty($this->id)) {
            throw new \CException('Идентификатор мероприятия не задан');
        }

        if (!file_exists($fileName)) {
            return false;
        }

        $fb = self::getFb();
        $fb->setFileUploadSupport(true);

        $squareFile = realpath($this->makeImageSquare($fileName));
        $result = $fb->api('/'.$this->id.'/picture', 'POST', ['source' => '@'.$squareFile]);
        @unlink($squareFile);
        return $result;
    }

    /**
     * Создает квадратное изображение из переданного, дополняя его прозрачным фоном. Созданное изображение
     * сохраняется во временной директории PublicTmp из конфигурации приложения
     * @param $fileName
     * @return string
     * @throws \CException
     */
    private function makeImageSquare($fileName)
    {
        if (!file_exists($fileName)) {
            throw new \CException("File $fileName does not exists!");
        }

        $im = new \Imagick($fileName);
        $w = $im->getImageWidth();
        $h = $im->getImageHeight();
        $size = max($im->getImageWidth(), $im->getImageHeight());

        $canvas = new \Imagick();
        $canvas->newImage($size, $size, 'none');

        if ($w > $h) {
            $canvas->compositeImage($im, \Imagick::COMPOSITE_OVER, 0, ($w - $h) / 2);
        } elseif ($w < $h) {
            $canvas->compositeImage($im, \Imagick::COMPOSITE_OVER, ($h - $w) / 2, 0);
        } else {
            $canvas->compositeImage($im, \Imagick::COMPOSITE_OVER, 0, 0);
        }

        $fullTmpName = \Yii::getPathOfAlias('webroot').\Yii::app()->params['PublicTmp'].
            substr(md5(time), 0, 10).substr(md5(rand()), 0, 10).'.png';

        $canvas->writeImage($fullTmpName);
        return $fullTmpName;
    }

    /**
     * Вовзвращает массив с информацией о мероприятии
     * @return array
     */
    private function getEventData()
    {
        $data = [];
        foreach (['name', 'start_time' => '_startTime', 'end_time' => '_endTime', 'description', 'location', 'ticket_uri' => 'ticketUri'] as $fieldName => $field) {
            $fieldName = is_numeric($fieldName) ? $field : $fieldName;
            if (!empty($this->{$field})) {
                $data[$fieldName] = $this->{$field};
            }
        }

        $data['access_token'] = $this->getFb()->getAccessToken();
        return $data;
    }
}
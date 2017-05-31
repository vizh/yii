<?php
namespace mail\components;

use mail\models\Log;

abstract class Mail
{
    protected $mailer;
    protected $attributes = [
        'toName' => '',
        'fromName' => 'RUNET-ID',
        'subject' => '',
        'html' => false,
        'attachments' => []
    ];

    public function __construct(Mailer $mailer, array $attributes = [])
    {
        $this->mailer = $mailer;
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    /**
     * Отправитель
     * @return string
     */
    abstract public function getFrom();

    /**
     * Получатель
     * @return string
     */
    abstract public function getTo();

    /**
     * Имя получателя
     * @return string
     */
    public function getToName()
    {
        return $this->attributes['toName'];
    }

    /**
     * Имя отправителя
     * @return string
     */
    public function getFromName()
    {
        return $this->attributes['fromName'];
    }

    /**
     * Тема письма
     * @return string
     */
    public function getSubject()
    {
        return $this->attributes['subject'];
    }

    /**
     * Отправлять письмо в HTML
     * @return bool
     */
    public function isHtml()
    {
        return $this->attributes['html'];
    }

    /**
     * Тело письма
     * @return string
     */
    abstract public function getBody();

    /**
     * Прилогаемые файлы
     * @return array
     */
    public function getAttachments()
    {
        return $this->attributes['attachments'];
    }

    /**
     * Отправка письма
     * @return bool
     */
    public function send()
    {
        if ($this->getBody() !== null && $this->getTo() !== null && ($this->getRepeat() || !$this->getIsHasLog())) {
            $this->mailer->send($this);
            return true;
        }

        return false;
    }

    /**
     * Проверка существования записи в логах
     * @return bool
     */
    public function getIsHasLog()
    {
        return Log::model()->byHash($this->getHash())->exists();
    }

    /**
     * @return ILog
     */
    public function getLog()
    {
        $log = new \mail\models\Log();
        $log->From = $this->getFrom();
        $log->To   = $this->getTo();
        $log->Subject = $this->getSubject();
        $log->Hash = $this->getHash();
        return $log;
    }

    /**
     * Возвращает хэш для письма письма
     * @return string
     */
    public function getHash()
    {
        $hash = md5(get_class($this).$this->getTo().$this->getSubject());
        if ($this->getHashSolt() !== null) {
            $hash .= $this->getHashSolt();
        }
        return $hash;
    }

    /**
     * Соль для хэша письма
     * @return null|string
     */
    protected function getHashSolt()
    {
        return null;
    }

    /**
     * Повторять письмо при возникновении события
     * @return bool
     */
    protected function getRepeat()
    {
        return true;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    protected function renderBody($view, $params)
    {
        $controller = new \CController('default', null);
        return $controller->renderPartial($view, $params, true);
    }

    /**
     * Отправлять письмо в приоритете
     * @return bool
     */
    public function getIsPriority()
    {
        return false;
    }

    /**
     * Проверяет существование представления для письма
     * @param $view
     * @return bool
     */
    protected function isViewExists($view)
    {
        $path = \Yii::getPathOfAlias($view) . '.php';
        return file_exists($path);
    }
}

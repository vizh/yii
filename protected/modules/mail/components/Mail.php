<?php
namespace mail\components;

use mail\models\Log;

abstract class Mail
{
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
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
        return '';
    }

    /**
     * Имя отправителя
     * @return string
     */
    public function getFromName()
    {
        return 'RUNET-ID';
    }

    /**
     * Тема письма
     * @return string
     */
    public function getSubject()
    {
        return '';
    }

    /**
     * Отправлять письмо в HTML
     * @return bool
     */
    public function isHtml()
    {
        return false;
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
        return [];
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

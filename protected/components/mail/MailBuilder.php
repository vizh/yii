<?php

namespace application\components\mail;

use api\models\Account;
use mail\components\mailers\SESMailer;
use Twig_Environment;
use Twig_Loader_Array;
use Twig_SimpleFilter;
use user\models\User;

class MailBuilder
{
    private $attributes = [];

    public static function create()
    {
        return new self();
    }

    /**
     * @return Mail
     */
    public function build()
    {
        return new Mail(new SESMailer(), $this->attributes);
    }

    public function send()
    {
        $this->build()->send();
    }

    /**
     * @param string|User $mail
     * @param string|null $name
     * @return MailBuilder
     */
    public function setTo($mail, $name = null)
    {
        if ($mail instanceof User) {
            $name = $mail->getFullName();
            $mail = $mail->Email;
        }

        $this->attributes['to'] = $mail;

        if (false === empty($name)) {
            $this->attributes['toName'] = $name;
        }

        return $this;
    }

    /**
     * @param string|User $mail
     * @param string|null $name
     * @return MailBuilder
     */
    public function setFrom($mail, $name = null)
    {
        if ($mail instanceof User) {
            $name = $mail->getFullName();
            $mail = $mail->Email;
        }

        $this->attributes['from'] = $mail;

        if ($name !== null) {
            $this->attributes['fromName'] = $name;
        }

        return $this;
    }

    /**
     * @param string $subject
     * @return MailBuilder
     */
    public function setSubject($subject)
    {
        $this->attributes['subject'] = $subject;

        return $this;
    }

    /**
     * @param string $body
     * @return MailBuilder
     */
    public function setBody($body)
    {
        $this->attributes['html'] = true;
        $this->attributes['body'] = $body;

        return $this;
    }

    /**
     * @param string $body
     * @param array $params
     * @return MailBuilder
     */
    public function setTemplatedBody($body, array $params = [])
    {
        $twig = new Twig_Environment(new Twig_Loader_Array(['index' => $body]));
        // Функционал генерации ссылок на быструю регистрацию
        $twig->addFilter(new Twig_SimpleFilter('registrationHash', function (User $user, $accountApiKey) {
                $account = Account::model()
                    ->byKey($accountApiKey)
                    ->find();

                return substr(md5($user->RunetId.$account->Secret), 0, 16);
            })
        );

        $this->setBody($twig->render('index', $params));

        return $this;
    }

    /**
     * Добавляет вложение к письму, если оно указано, существует и является файлом.
     *
     * @param string $file
     * @param string|null $name
     * @return MailBuilder
     */
    public function addAttachment($file, $name = null)
    {
        if ($file && is_file($file)) {
            if ($name === null) {
                $name = basename($file);
            }

            $this->attributes['attachments'][$name] = [
                mime_content_type($file),
                $file
            ];
        }

        return $this;
    }
}
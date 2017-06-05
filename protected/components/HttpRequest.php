<?php
namespace application\components;

class HttpRequest extends \CHttpRequest
{
    /**
     * Normalizes the request data.
     * This method strips off slashes in request data if get_magic_quotes_gpc() returns true.
     * It also performs CSRF validation if {@link enableCsrfValidation} is true.
     */
    protected function normalizeRequest()
    {
        // normalize request
        if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            if (isset($_GET)) {
                $_GET = $this->stripSlashes($_GET);
            }
            if (isset($_POST)) {
                $_POST = $this->stripSlashes($_POST);
            }
            if (isset($_REQUEST)) {
                $_REQUEST = $this->stripSlashes($_REQUEST);
            }
            if (isset($_COOKIE)) {
                $_COOKIE = $this->stripSlashes($_COOKIE);
            }
        }
    }

    /**
     * Creates a cookie with a randomly generated CSRF token.
     * Initial values specified in {@link csrfCookie} will be applied
     * to the generated cookie.
     * @return CHttpCookie the generated cookie
     * @see enableCsrfValidation
     */
    protected function createCsrfCookie()
    {
        $cookie = new \CHttpCookie($this->csrfTokenName, sha1(uniqid(mt_rand(), true)), ['domain' => '.'.RUNETID_HOST]);
        if (is_array($this->csrfCookie)) {
            foreach ($this->csrfCookie as $name => $value) {
                $cookie->$name = $value;
            }
        }
        return $cookie;
    }

    /**
     * Возвращает схему соединения
     * @return string
     */
    public function getSchema()
    {
        return ($this->isSecureConnection ? 'https' : 'http').'://';
    }
}
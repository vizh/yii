<?php

class Iframe
{
    /**
     * @return bool
     *
     * Проверка открыто окно во фрейме или нет
     */
    public static function isFrame()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();

        $referrer = $request->getUrlReferrer();
        $URI = $request->getRequestUri();
        $host = $request->getHostInfo();

        $isUriFrame = strpos($URI, 'frame');
        $isReferrerFrame = strpos($referrer, 'frame');

        if (($isUriFrame || $isReferrerFrame) && strpos($host, RUNETID_HOST)) {
            return true;
        } elseif ((!$isUriFrame || !$isReferrerFrame) && strpos($host, RUNETID_HOST)) {
            return false;
        } elseif ($isUriFrame) {
            return true;
        } else {
            return false;
        }
    }
}

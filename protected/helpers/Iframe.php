<?php

class Iframe
{
    /**
     * @return bool
     *
     * Проверка открыто окно во фрейме или нет
     */

    public function isFrame()
    {
        $requestReferrer = \Yii::app()->request->urlReferrer; //var_dump($requestURI);
        $requestURI = \Yii::app()->request->requestUri;
        $requerstHost = \Yii::app()->request->hostInfo;
        if ((strpos($requestURI, 'frame') || strpos($requestReferrer, 'frame')) && strpos($requerstHost, 'runet-id')){
            return true;
        }
        elseif((!strpos($requestURI, 'frame') || !strpos($requestReferrer, 'frame')) && strpos($requerstHost, 'runet-id')){
            return false;
        }
        elseif(strpos($requestURI, 'frame'))
        {

            return true;
        }
        else {
            return false;
        }
    }
}
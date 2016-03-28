<?php
namespace ruvents\components;

class QrCode
{
    const FORMAT = '~RUNETID#{RunetId}$';

    public static function getAbsoluteUrl($user, $size = 100)
    {
        $data = str_replace('{RunetId}', $user->RunetId, self::FORMAT);
        $path = '/files/ruvents/qrcode/' . $user->RunetId . '_' . $size . '.png';
        $absolutePath = \Yii::getPathOfAlias('webroot') . $path;
        if (!file_exists($absolutePath)) {
            $googleChartApiUrl = 'http://chart.apis.google.com/chart?cht=qr&chs=' . $size . 'x' . $size . '&chl=' . urlencode($data);
            file_put_contents($absolutePath, file_get_contents($googleChartApiUrl));
        }

        return 'http://' . RUNETID_HOST . $path;
    }
}

<?php
namespace application\components\graphics;

/**
 *
 */
class Image
{
    /**
     * @static
     * @param string $postname Имя загружаемого файла в _FILES
     * @param string $saveTo Путь куда сохранять файл
     * @return bool
     */
    public static function SaveImageFromPost($postname, $saveTo)//, $width, $height, $area = array())
    {
        $maxFileSize = \Yii::app()->params['MaxFileSize'];
        $img = $_FILES[$postname]['tmp_name'];
        $img_size = $_FILES[$postname]['size'];

        if ($maxFileSize < $img_size || !is_uploaded_file($img)) {
            return false;
        }

        $img = self::GetImage($img);
        if ($img == null || !$img) {
            return false;
        }

        imagejpeg($img, $saveTo, 100);
        imagedestroy($img);

        return true;
    }

    /**
     * @static
     * @param string $imageName
     * @param string $newImageName
     * @param int $width Ширина
     * @param int $height Высота
     * @param array $area x1,y1 - левый верхний угол; x2, y2 - правый нижний угол
     * @return void
     */
    public static function ResizeAndSave($imageName, $newImageName, $width, $height, $area = [], $saveType = IMAGETYPE_JPEG)
    {
        $image = self::GetImage($imageName);
        if ($image == null || !$image) {
            return;
        }
        $imgSizeArray = getimagesize($imageName);
        $originalWidth = $imgSizeArray[0];
        $originalHeight = $imgSizeArray[1];

        $area['x1'] = isset($area['x1']) ? $area['x1'] : 0;
        $area['y1'] = isset($area['y1']) ? $area['y1'] : 0;
        if (!(isset($area['x2']) && isset($area['y2']))) {
            $area['width'] = $originalWidth - $area['x1'];
            $area['height'] = $originalHeight - $area['y1'];
        } elseif (!isset($area['x2'])) {
            $area['width'] = $originalWidth - $area['x1'];
            $area['height'] = $area['y2'] - $area['y1'];
        } elseif (!isset($area['y2'])) {
            $area['width'] = $area['x2'] - $area['x1'];
            $area['height'] = $originalHeight - $area['y1'];
        } else {
            $area['width'] = $area['x2'] - $area['x1'];
            $area['height'] = $area['y2'] - $area['y1'];
        }

        if ($width == 0 && $height == 0) {
            $width = $area['width'];
            $height = $area['height'];
        } elseif ($width == 0) {
            $width = $area['width'] * $height / $area['height'];
        } elseif ($height == 0) {
            $height = $area['height'] * $width / $area['width'];
        }

        $h = min($area['height'], $area['width'] * $height / $width);
        $w = $h * $width / $height;

        $newImage = imagecreatetruecolor($width, $height);
        if ($saveType == IMAGETYPE_PNG) {
            imagealphablending($newImage, true);
            imagesavealpha($newImage, true);
        }

        imagecopyresampled($newImage, $image, 0, 0, $area['x1'], $area['y1'],
            $width, $height, $w, $h);//$area['width'], $area['height']);
        if ($saveType == IMAGETYPE_PNG) {
            imagepng($newImage, $newImageName);
        } else {
            imagejpeg($newImage, $newImageName, 100);
        }
        imagedestroy($image);
        imagedestroy($newImage);
    }

    public static function GetImage($path)
    {
        $imgSizeArray = getimagesize($path);
        $originalType = $imgSizeArray[2];

        switch ($originalType) {
            case IMAGETYPE_GIF:
                return imagecreatefromgif($path);
                break;
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($path);
                break;
            case IMAGETYPE_PNG:
                return imagecreatefrompng($path);
                break;
            case IMAGETYPE_BMP:
                return imagecreatefromwbmp($path);
                break;
            default:
                return null;
        }
    }
}

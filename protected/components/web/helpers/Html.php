<?php
namespace application\components\web\helpers;

/**
 * Class Html
 * @package application\components\web\helpers
 */
class Html extends \CHtml
{
    /**
     * Html тэг, ограчениенный по длине содержимого.
     * Если содержимое больше допустимого значения, размер шрифта будет уменьшем до размера,
     * при котором содержимое будет помещаться.
     *
     */
    public static function limitedTag($tag, $content, $fontsize, $width, $height, $htmlOptions = [], $step = 1)
    {
        $imagick = new \Imagick();
        $draw = new \ImagickDraw();
        $words = explode(' ', strip_tags($content));
        while (true) {
            $draw->setFontSize($fontsize);
            $w = 0;
            $h = 0;
            $s = $imagick->queryFontMetrics($draw, ' ')['textWidth'];
            foreach ($words as $word) {
                $metrics = $imagick->queryFontMetrics($draw, $word);
                if ($h === 0) {
                    $h = $metrics['textHeight'];
                }

                $w += ($metrics['textWidth'] + $s);
                if ($w > $width) {
                    $w = $metrics['textWidth'];
                    $h += $metrics['textHeight'];
                }
            }
            if ($h <= $height) {
                break;
            }
            $fontsize -= $step;
        }

        $htmlOptions['style'] = isset($htmlOptions['style']) ? (rtrim($htmlOptions['style'], ';').';') : '';
        $htmlOptions['style'] .= 'font-size:'.$fontsize.'px';
        return parent::tag($tag, $htmlOptions, $content);
    }

}